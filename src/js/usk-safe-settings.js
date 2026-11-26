/**
 * Safe values from widget markup
 *
 * Slider handlers read their options from data-settings. That attribute is
 * only trustworthy when the widget printed it: markup that imitates a widget
 * (a comment or excerpt that keeps class and data-* through KSES) reaches the
 * same handler. Swiper resolves navigation/pagination selectors through a
 * helper that builds elements from any string holding "<", and writes some
 * string options into markup, so values that could carry markup are dropped.
 * Ultimate Store Kit and Ultimate Store Kit Pro both ship this; the first one
 * loaded wins.
 */
(function (window) {

    'use strict';

    var UNSAFE_STRING = /[<>"'`]/;

    if (typeof window.uskSafeSwiperSettings !== 'function') {
        /**
         * Swiper options read from widget markup: plain JSON values only, no string
         * that could carry markup, and none of the options Swiper turns into markup.
         */
        window.uskSafeSwiperSettings = function (settings) {
            var DROPPED_KEYS = ['virtual', 'injectStyles', 'injectStylesUrls', 'on', 'modules', '__proto__', 'constructor', 'prototype'];

            var clean = function (value, depth) {
                if (depth > 6) {
                    return undefined;
                }
                if (value === null || typeof value === 'boolean') {
                    return value;
                }
                if (typeof value === 'number') {
                    return isFinite(value) ? value : undefined;
                }
                if (typeof value === 'string') {
                    return UNSAFE_STRING.test(value) ? undefined : value;
                }
                if (Array.isArray(value)) {
                    return value.map(function (item) {
                        return clean(item, depth + 1);
                    }).filter(function (item) {
                        return item !== undefined;
                    });
                }
                if (typeof value === 'object') {
                    var out = {};
                    Object.keys(value).forEach(function (key) {
                        if (DROPPED_KEYS.indexOf(key) !== -1) {
                            return;
                        }
                        var item = clean(value[key], depth + 1);
                        if (item !== undefined) {
                            out[key] = item;
                        }
                    });
                    return out;
                }
                return undefined;
            };

            var out = clean(settings, 0);
            if (!out || typeof out !== 'object' || Array.isArray(out)) {
                out = {};
            }

            // Swiper writes bulletElement into markup as a tag name.
            if (out.pagination && typeof out.pagination === 'object' && 'bulletElement' in out.pagination &&
                !/^[a-z][a-z0-9-]*$/i.test(String(out.pagination.bulletElement))) {
                delete out.pagination.bulletElement;
            }

            return out;
        };
    }

    if (typeof window.uskSafeHtml !== 'function') {
        /**
         * HTML read from widget markup (a tooltip's content), reduced to inline
         * formatting, links and images. Entity-encoded markup survives KSES and is
         * decoded by the browser in an attribute, so the string is parsed first (in
         * an inert template) and the tree the browser would build is filtered: other
         * elements are unwrapped, and only the listed attributes are kept, without
         * script URLs.
         */
        window.uskSafeHtml = function (input) {
            var COMMON = ['class', 'style'];
            var ALLOWED = {
                a: ['href', 'title', 'target', 'rel'],
                abbr: ['title'],
                article: [], aside: [], b: [], blockquote: ['cite'], br: [], code: [], del: [], div: [], em: [],
                footer: [], h1: [], h2: [], h3: [], h4: [], h5: [], h6: [], header: [], hr: [], i: [],
                img: ['src', 'alt', 'title', 'width', 'height'],
                ins: [], li: [], main: [], mark: [], nav: [], ol: [], p: [], pre: [], s: [], section: [],
                small: [], span: [], strong: [], sub: [], sup: [],
                table: [], tbody: [], td: ['colspan', 'rowspan'], tfoot: [], th: ['colspan', 'rowspan', 'scope'],
                thead: [], tr: [], u: [], ul: []
            };
            var URL_ATTRIBUTES = ['href', 'src', 'cite'];
            var UNSAFE_URL = /^(?:javascript|vbscript|data):/i;

            var template = document.createElement('template');
            template.innerHTML = String(input === null || input === undefined ? '' : input);

            var clean = function (parent) {
                Array.prototype.slice.call(parent.childNodes).forEach(function (node) {
                    if (node.nodeType === 3) {
                        return;
                    }
                    if (node.nodeType !== 1) {
                        parent.removeChild(node);
                        return;
                    }

                    // Depth first, so an element is clean before it is kept or unwrapped.
                    clean(node);

                    var tag = node.tagName.toLowerCase();

                    if (!Object.prototype.hasOwnProperty.call(ALLOWED, tag)) {
                        while (node.firstChild) {
                            parent.insertBefore(node.firstChild, node);
                        }
                        parent.removeChild(node);
                        return;
                    }

                    Array.prototype.slice.call(node.attributes).forEach(function (attribute) {
                        var name = attribute.name.toLowerCase();
                        var allowed = ALLOWED[tag].indexOf(name) !== -1 || COMMON.indexOf(name) !== -1;

                        // Browsers ignore control characters and spaces in a URL scheme.
                        if (allowed && URL_ATTRIBUTES.indexOf(name) !== -1 &&
                            UNSAFE_URL.test(String(attribute.value).replace(/[\u0000- \u007f-\u009f]/g, ''))) {
                            allowed = false;
                        }
                        if (!allowed) {
                            node.removeAttribute(attribute.name);
                        }
                    });
                });
            };

            clean(template.content);

            return template.innerHTML;
        };
    }

    if (typeof window.uskSafeUrl !== 'function') {
        /**
         * A link read from widget markup, or an empty string unless it is a web, mail,
         * phone or relative link. data-* attributes are not URL attributes, so KSES
         * keeps "javascript:" in them.
         */
        window.uskSafeUrl = function (url) {
            if (typeof url !== 'string') {
                return '';
            }

            var value = url.trim();
            var scheme = /^([a-z][a-z0-9+.\-]*):/i.exec(value.replace(/[\u0000- \u007f-\u009f]/g, ''));

            if (scheme && ['http', 'https', 'mailto', 'tel'].indexOf(scheme[1].toLowerCase()) === -1) {
                return '';
            }

            return value;
        };
    }

    if (typeof window.uskSafeTippy !== 'function') {
        /**
         * Drop-in for tippy(element, props).
         *
         * tippy reads every data-tippy-* attribute of its target, renders a string
         * content with innerHTML when allowHTML is on, and builds an arrow that is
         * not `true` as markup. Page content can imitate a widget and carry such
         * attributes, so only plain option attributes are read here, HTML content
         * goes through uskSafeHtml(), the arrow is a boolean, and tippy's own
         * attribute reading is switched off.
         */
        window.uskSafeTippy = function (element, props) {
            if (typeof window.tippy !== 'function' || !element || typeof element.getAttribute !== 'function') {
                return null;
            }

            var ATTRIBUTES = ['content', 'placement', 'animation', 'arrow', 'offset', 'trigger', 'theme', 'delay', 'duration', 'interactive', 'maxWidth', 'hideOnClick', 'zIndex', 'inertia', 'showOnCreate'];
            var options = {};

            Object.keys(props || {}).forEach(function (key) {
                options[key] = props[key];
            });

            ATTRIBUTES.forEach(function (key) {
                var raw = element.getAttribute('data-tippy-' + key);

                if (raw === null || raw.trim() === '') {
                    return;
                }

                if ('content' === key) {
                    options.content = raw;
                    return;
                }

                try {
                    options[key] = JSON.parse(raw);
                } catch (e) {
                    options[key] = raw.trim();
                }
            });

            var safeContent = function (content) {
                if (content === null || content === undefined) {
                    return '';
                }
                // Nodes a handler builds itself are passed through.
                if (typeof content !== 'string') {
                    return content;
                }
                return options.allowHTML ? window.uskSafeHtml(content) : content;
            };

            if (typeof options.content === 'function') {
                var contentCallback = options.content;
                options.content = function (reference) {
                    return safeContent(contentCallback(reference));
                };
            } else {
                options.content = safeContent(options.content);
            }

            if (Object.prototype.hasOwnProperty.call(options, 'arrow')) {
                options.arrow = options.arrow === true || options.arrow === 'true';
            }

            options.ignoreAttributes = true;

            return window.tippy(element, options);
        };
    }

}(window));
