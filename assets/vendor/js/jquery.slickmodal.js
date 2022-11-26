/**
 * Slick Modals - HTML5 and CSS3 Powered Modal Popups
 * ---------------------------------------------------
 * @file      Defines main jQuery plugin
 * @author    Capelle @ Codecanyon
 * @copyright @author
 * @version   5.0
 * @url       https://codecanyon.net/item/slick-modal-css3-powered-popups/12335988
 */

(function ($) {
    'use strict';

    // Error checking
    if (!$ || typeof $ === 'undefined') return _log('[Slick Modals] No jQuery library detected. Load SlickModals after jQuery has been loaded on the page.');

    // Defaults
    var _defaults = {

        // Restrictions
        restrict_hideOnUrls                   : [],
        restrict_cookieSet                    : false,
        restrict_cookieName                   : 'slickModal-1',
        restrict_cookieScope                  : 'domain',
        restrict_cookieDays                   : '30',
        restrict_cookieSetClass               : 'setSmCookie-1',
        restrict_dateRange                    : false,
        restrict_dateRangeStart               : '',
        restrict_dateRangeEnd                 : '',
        restrict_dateRangeServerTime          : true,
        restrict_dateRangeServerTimeFile      : '',
        restrict_dateRangeServerTimeZone      : 'Europe/London',
        restrict_showAfterVisits              : 1,
        restrict_showAfterVisitsResetWhenShown: false,

        // Popup
        popup_type                    : 'none',
        popup_delayedTime             : '1s',
        popup_scrollDistance          : '400px',
        popup_scrollHideOnUp          : false,
        popup_exitShowAlways          : false,
        popup_autoClose               : false,
        popup_autoCloseAfter          : '5s',
        popup_openWithHash            : false,
        popup_redirectOnClose         : false,
        popup_redirectOnCloseUrl      : '',
        popup_redirectOnCloseTarget   : '_blank',
        popup_redirectOnCloseTriggers : 'overlay button',
        popup_position                : 'center',
        popup_animation               : 'fadeIn',
        popup_closeButtonEnable       : true,
        popup_closeButtonStyle        : 'cancel simple',
        popup_closeButtonAlign        : 'right',
        popup_closeButtonPlace        : 'outside',
        popup_closeButtonText         : 'Close',
        popup_reopenClass             : 'open-sm',
        popup_reopenClassTrigger      : 'click',
        popup_reopenStickyButtonEnable: false,
        popup_reopenStickyButtonText  : 'Open popup',
        popup_enableESC               : true,
        popup_bodyClass               : '',
        popup_wrapperClass            : '',
        popup_draggableEnable         : false,
        popup_allowMultipleInstances  : false,
        popup_css                     : {
            'width'             : '480px',
            'height'            : 'auto',
            'background'        : '#fff',
            'margin'            : '24px',
            'padding'           : '24px',
            'animation-duration': '0.4s'
        },

        // Overlay
        overlay_isVisible  : true,
        overlay_closesPopup: true,
        overlay_animation  : 'fadeIn',
        overlay_css        : {
            'background'        : 'rgba(0, 0, 0, .8)',
            'animation-duration': '0.4s',
            'animation-delay'   : '0s'
        },

        // Content
        content_loadViaAjax: false,
        content_animate    : false,
        content_animation  : 'zoomIn',
        content_css        : {
            'animation-duration': '0.4s',
            'animation-delay'   : '0.4s'
        },

        // Page
        page_animate          : false,
        page_animation        : 'scale',
        page_animationDuration: '.4s',
        page_blurRadius       : '1px',
        page_scaleValue       : '.9',
        page_moveDistance     : '30%',

        // Mobile
        mobile_show      : true,
        mobile_breakpoint: '480px',
        mobile_position  : 'bottomCenter',
        mobile_css       : {
            'width'             : '100%',
            'height'            : 'auto',
            'background'        : '#fff',
            'margin'            : '0',
            'padding'           : '18px',
            'animation-duration': '0.4s'
        },

        // Callbacks
        callback_beforeInit  : $.noop,
        callback_afterInit   : $.noop,
        callback_beforeOpen  : $.noop,
        callback_afterOpen   : $.noop,
        callback_afterVisible: $.noop,
        callback_beforeClose : $.noop,
        callback_afterClose  : $.noop,
        callback_afterHidden : $.noop

    };

    // Constants
    var _PLUGIN_NAME = 'SlickModals';
    var _PREFIX      = 'sm-';
    var _LOG_START   = '[Slick Modals] ';
    var _LOG_END_1   = ' can be passed into this method.';

    // Helpers
    function _log(val) {
        console.log(val);
    }
 
    // Main constructor
    function SlickModals (element, config) {
        this.$el      = $(element);
        this.$wrapper = '';
        this.$overlay = '';
        this.$popup   = '';
        this.settings = $.extend(true, {}, _defaults, config);

        this.autoCloseTimer    = null;
        this.ajaxContentLoaded = 0;

        this._build();
    };

    // Plugin methods
    SlickModals.prototype = {
        constructor: SlickModals,

        // @private
        _build: function () {

            if (this.$el.attr('data-sm-init') !== 'true') {
                this.$el.hide();
                return _log(_LOG_START + 'Element is missing data-sm-init="true" attribute.');
            }

            this.settings.callback_beforeInit();
            this._createParent();
            if (this.settings.overlay_isVisible) this._createOverlay();
            if (this.settings.popup_reopenStickyButtonEnable) this._createStickyButton();

            this._createPopup();
            if (this.settings.content_animate) this._contentAnimate();

            this._createEvents();
            this._checkInitRestrictions();
        },
        _createParent: function () {
            this.$el.wrapAll('<div class="' + _PREFIX + 'wrapper"></div>');
            this.$wrapper = this.$el.parent();

            var type    = this.settings.popup_type;
            var typeVal = 0;

            switch (true) {

                case (type === 'delayed'):
                    typeVal = this.settings.popup_delayedTime;
                    break;

                case (type === 'scrolled'):
                    typeVal = this.settings.popup_scrollDistance;
                    break;
            }

            this.$wrapper.attr({
                'data-sm-type'    : type,
                'data-sm-type-val': typeVal
            });

            if (this.settings.popup_autoClose) {
                this.$wrapper.attr({
                    'data-sm-autoClose'      : 'enable',
                    'data-sm-autoClose-after': this.settings.popup_autoCloseAfter
                });
            }
        },
        _createOverlay: function () {
            this.$wrapper.prepend('<div class="' + _PREFIX + 'overlay"></div>');
            this.$overlay = this.$wrapper.children('.' + _PREFIX + 'overlay');

            this.$overlay.attr({
                'data-sm-animated': true,
                'data-sm-close'   : this.settings.overlay_closesPopup,
                'data-sm-effect'  : this.settings.overlay_animation
            }).css(this.settings.overlay_css);
        },
        _createStickyButton: function () {
            if (this.settings.popup_reopenClass === '') return _log(_LOG_START + 'Sticky button must have defined "popup_reopenClass" within the plugin settings.');
            $('body').append('<div class="' + _PREFIX + 'sticky-button ' + this.settings.popup_reopenClass + '">' + this.settings.popup_reopenStickyButtonText + '</div>');
        },
        _createPopup: function () {
            this.$el.attr('data-sm-init', 'false').wrapAll('<div class="' + _PREFIX + 'popup"></div>');
            this.$popup = this.$wrapper.children('.' + _PREFIX + 'popup');

            var isMobile = $(window).width() <= parseInt(this.settings.mobile_breakpoint);
            var popupCss = null;

            (isMobile) ? popupCss = this.settings.mobile_css : popupCss = this.settings.popup_css;
            popupCss['animation-delay'] = ((this.settings.overlay_isVisible) ? parseFloat(this.settings.overlay_css['animation-duration']) / 2 : 0) + 's';

            this.$popup
                .attr({
                    'data-sm-animated': true,
                    'data-sm-position': (isMobile) ? this.settings.mobile_position : this.settings.popup_position,
                    'data-sm-effect'  : this.settings.popup_animation
                })
                .css(popupCss)
                .prepend(
                    (this.settings.popup_closeButtonEnable)
                        ?
                        '<div class="sm-button" '+
                        'data-sm-button-style="' + this.settings.popup_closeButtonStyle + '" ' +
                        'data-sm-button-align="' + this.settings.popup_closeButtonAlign + '" ' +
                        'data-sm-button-place="' + this.settings.popup_closeButtonPlace + '" ' +
                        'data-sm-button-text="'  + this.settings.popup_closeButtonText  + '" ' +
                        'data-sm-close="true"></div>'
                        : '',
                    (this.settings.popup_draggableEnable)
                        ?
                        '<div class="sm-draggable"></div>'
                        : ''
                );

            this._popupPositionCorrect();
        },
        _contentAnimate: function () {
            this.$el.attr({
                'data-sm-animated': true,
                'data-sm-effect'  : this.settings.content_animation
            }).css(this.settings.content_css);
        },
        _checkInitRestrictions: function () {
            var self = this;

            function cookieExist () {
                if (!self.settings.restrict_cookieSet) return false;
                return document.cookie.indexOf(self.settings.restrict_cookieName) > -1;
            }

            function hiddenOnPage () {
                if (!self.settings.restrict_hideOnUrls.length) return false;
                var restrictedUrls = self.settings.restrict_hideOnUrls;

                for (var i = 0; i < restrictedUrls.length; i++) {
                    var url = restrictedUrls[i];
                    var path = window.location.pathname;
                    if ((url instanceof RegExp && url.test(path)) ||
                        (typeof url === 'string' && path.indexOf(url) > -1)) {
                        return true;
                    }
                }

                return false;
            }

            function hideOnMobile () {
                if (self.settings.mobile_show) return false;
                return !self.settings.mobile_show && $(window).width() <= parseInt(self.settings.mobile_breakpoint);
            }

            function checkDateRange (callback) {

                var compareDates = function (now) {
                    function formatDate (range) {
                        var date = new Date(range.split(',')[0] + 'T' + range.split(',')[1].replace(' ', '')).getTime();
                        if (isNaN(date)) return _log(_LOG_START + 'Invalid date format.');

                        return date;
                    }

                    var start = formatDate(self.settings.restrict_dateRangeStart);
                    var end   = formatDate(self.settings.restrict_dateRangeEnd);

                    callback(!(now > start && now < end && start < end));
                };

                if (self.settings.restrict_dateRangeServerTime && self.settings.restrict_dateRangeServerTimeFile !== '') {
                    $.ajax({
                        url     : self.settings.restrict_dateRangeServerTimeFile,
                        type    : 'POST',
                        data    : {'timezone': self.settings.restrict_dateRangeServerTimeZone},
                        dataType: 'json',
                        success : function (response) {
                            compareDates(new Date(response).getTime());
                        },
                        error   : function () {
                            _log(_LOG_START + 'Ajax request error upon retrieving server time.')
                        }
                    });
                } else {
                    compareDates(new Date().getTime());
                }
            }

            function restrictedVisits () {
                var visitsVal = parseInt(self.settings.restrict_showAfterVisits);
                if (visitsVal <= 1) return false;
                var keyName = _PREFIX + 'visits-' + self.$el.attr('class');

                if (visitsVal > 1) {
                    var storageItem = localStorage.getItem(keyName);

                    if (storageItem !== null) {
                        if (parseInt(storageItem) === (visitsVal - 1)) {
                            if (self.settings.restrict_showAfterVisitsResetWhenShown) localStorage.removeItem(keyName);
                            return false;
                        } else {
                            localStorage.setItem(keyName, parseInt(storageItem) + 1);
                            return true;
                        }
                    } else {
                        localStorage.setItem(keyName, '1');
                        return true;
                    }

                } else {
                    localStorage.removeItem(keyName);
                }
            }

            function triggerOpen (hide) {
                self.settings.callback_afterInit();
                if (!hide) self.openPopup();
            }

            if (self.settings.restrict_dateRange) {
                checkDateRange(function (outsideDateRange) {
                    triggerOpen(!!(cookieExist() || hiddenOnPage() || hideOnMobile() || self._activeInstanceExist() || restrictedVisits() || outsideDateRange));
                });
            } else {
                triggerOpen(!!(cookieExist() || hiddenOnPage() || hideOnMobile() || self._activeInstanceExist() || restrictedVisits()));
            }

        },
        _activeInstanceExist: function () {
            if (!this.settings.popup_allowMultipleInstances && $('.' + _PREFIX + 'wrapper.' + _PREFIX + 'active').length > 0) {
                _log(_LOG_START + 'Another Slick Modal instance is already active.');
                return true;
            }

            return false;
        },
        _popupPositionCorrect: function () {
            var position = this.$popup.attr('data-sm-position');

            switch (true) {

                case (position === 'center'):
                    this.$popup.css('margin', 'auto');
                    break;

                case ((position === 'bottomCenter') || (position === 'topCenter')):
                    this.$popup.css({
                        'margin-left' : 'auto',
                        'margin-right': 'auto'
                    });
                    break;

                case ((position === 'right') || (position === 'left')):
                    this.$popup.css({
                        'margin-top'   : 'auto',
                        'margin-bottom': 'auto'
                    });
                    break;
            }
        },
        _popupCalculateHeight: function () {
            var innerElemsHeight = 0;
            this.$popup.children().not('.sm-button').each(function () {
                innerElemsHeight += $(this).outerHeight(true);
            });

            this.$popup.height(innerElemsHeight);
        },
        _createEvents: function () {
            var self = this;

            if (self.$wrapper.find('[data-sm-close="true"]').length > 0) {
                self.$wrapper.find('[data-sm-close="true"]').each(function () {
                    var $this = $(this);
                    $this.on('click', function () {
                        self.closePopup();

                        if (self.settings.popup_redirectOnClose &&
                            self.settings.popup_redirectOnCloseTriggers.indexOf($this.attr('class').replace('sm-', '')) > -1 &&
                            self.settings.popup_redirectOnCloseTriggers.indexOf('close') === -1) {
                            self._redirectOnClose();
                        }
                    });
                });
            }

            if (self.settings.popup_reopenClass !== '') {
                $('body').on((self.settings.popup_reopenClassTrigger === 'click') ? 'click' : 'mouseover', '.' + self.settings.popup_reopenClass , function(e) {
                    if ($(e.target).is('a')) e.preventDefault();
                    self.openPopup('instant');
                });
            }

            if (self.settings.popup_enableESC) {
                $(window).on('keydown', function(e) {
                    if (e.keyCode === 27 && self._wrapperActive()) self.closePopup();
                });
            }

            if (self.settings.popup_openWithHash) {
                var userHash  = self.settings.popup_openWithHash;
                var hashValid = (userHash !== false && userHash !== '' && userHash.charAt(0) === '#');

                if (hashValid) {
                    $(window).on('load hashchange', function() {
                        if (hashValid && userHash === window.location.hash) self.openPopup('instant');
                    });
                }
            }

            if (this.settings.popup_draggableEnable) {
                var dragging = dragging || false;
                var $target  = self.$popup;
                var mrgTop   = !isNaN(parseInt($target.css('margin-top')))  ? parseInt($target.css('margin-top'))  : 0;
                var mrgLeft  = !isNaN(parseInt($target.css('margin-left'))) ? parseInt($target.css('margin-left')) : 0;
                var mrgAuto  = $target.css('margin') === 'auto';
                var yPos, xPos, yOff, xOff;

                var moveTarget = function (e) {
                    $target.css({
                        'top':  e.clientY - yPos + yOff + 'px',
                        'left': e.clientX - xPos + xOff + 'px'
                    });
                };

                $target.children('.' + _PREFIX + 'draggable').on('mousedown', function (e) {
                    dragging = true;

                    yPos = e.clientY + mrgTop;
                    xPos = e.clientX + mrgLeft;
                    yOff = $target.offset().top;
                    xOff = $target.offset().left;

                    if (mrgAuto) {
                        $target.css('margin', '0px');
                        moveTarget(e);
                        mrgAuto = false;
                    }

                    $(window).on('mousemove', function (e) {
                        if (dragging) {
                            moveTarget(e);
                            return false;
                        }
                    });

                    $(window).on('mouseup', function () {
                        dragging = false;
                    });
                });
            }
        },
        _setCookie: function () {
            var days = parseInt(this.settings.restrict_cookieDays);
            var CookieDate = new Date();
            var scopeSetting = '/';

            if (this.settings.restrict_cookieScope === 'page') scopeSetting = window.location.href;

            CookieDate.setTime(CookieDate.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = this.settings.restrict_cookieName + '=1; path=' + scopeSetting + '; expires=' + ((days > 0) ? CookieDate.toGMTString() : 0);
        },
        _redirectOnClose: function () {
            var redirectUrl = this.settings.popup_redirectOnCloseUrl;
            if (redirectUrl !== '' && redirectUrl.indexOf('http') > -1) {
                window.open(redirectUrl, this.settings.popup_redirectOnCloseTarget);
            } else {
                _log(_LOG_START + 'Redirect URL is empty or not valid.');
            }
        },
        _loadContentViaAjax: function () {
            if (!this.ajaxContentLoaded && this.settings.content_loadViaAjax !== '') {
                var self = this;
                $.ajax({
                    url     : self.settings.content_loadViaAjax,
                    type    : 'GET',
                    dataType: 'html',
                    success : function (response) {
                        self.$el.html(response);
                        self._popupCalculateHeight();
                        self.ajaxContentLoaded = 1;
                    },
                    error   : function () {
                        _log(_LOG_START + 'Ajax request error upon retrieving the content.')
                    }
                });
            }
        },
        _pageAnimation: function (action) {

            var pageAnimation = this.settings.page_animation;
            var $bodyChildren = $('body').children().not('.' + _PREFIX + 'wrapper, .' + _PREFIX + 'sticky-button, script, style');

            if (action === 'enable') {
                switch (true) {

                    case (pageAnimation === 'blur'):
                        $bodyChildren
                            .css({
                                'filter'             : 'blur(' + this.settings.page_blurRadius + ')',
                                'transition-duration': this.settings.page_animationDuration
                            });
                        break;

                    case (pageAnimation === 'scale'):
                        $bodyChildren
                            .css({
                                'transform'          : 'scale(' + this.settings.page_scaleValue + ')',
                                'transition-duration': this.settings.page_animationDuration
                            });
                        break;

                    case (pageAnimation.indexOf('move') > -1):
                        var axis = '';
                        var sign = '';

                        switch (true) {
                            case (pageAnimation === 'moveUp'):
                                axis = 'Y';
                                sign = '-';
                                break;
                            case (pageAnimation === 'moveDown'):
                                axis = 'Y';
                                sign = '';
                                break;
                            case (pageAnimation === 'moveLeft'):
                                axis = 'X';
                                sign = '-';
                                break;
                            case (pageAnimation === 'moveRight'):
                                axis = 'X';
                                sign = '';
                                break;
                        }

                        $bodyChildren
                            .css({
                                'transform'          : 'translate' + axis + '(' + sign + '' + this.settings.page_moveDistance + ')',
                                'transition-duration': this.settings.page_animationDuration
                            });
                        break;
                }
                $('body').addClass(_PREFIX + 'pageAnimated');
            } else {
                $bodyChildren.css({
                    'transform': '',
                    'filter'   : ''
                });
                $('body').removeClass(_PREFIX + 'pageAnimated');
            }
        },
        _wrapperActive: function () {
            return this.$wrapper.hasClass(_PREFIX + 'active');
        },
        _prepareClose: function () {
            var self = this;
            var popupAnimationDuration = self.$popup.css('animation-duration');
            var currentOverlayDelay = (self.settings.overlay_isVisible) ? self.$overlay.css('animation-delay') : 0;
            var currentContentDelay = self.$el.css('animation-delay') || 0;
            var currentPopupDelay = self.$popup.css('animation-delay') || 0;

            if (self.settings.overlay_isVisible) self.$overlay.css('animation-delay', popupAnimationDuration);
            if (self.settings.content_animate) self.$el.css('animation-delay', '0s');

            self.$popup.css('animation-delay', '0s');
            var finishTime = (((self.settings.overlay_isVisible) ? parseFloat(self.$overlay.css('animation-duration')) : 0) + parseFloat(popupAnimationDuration)) * 1000;

            self._togglePopup('disable', finishTime, currentPopupDelay, currentOverlayDelay, currentContentDelay);
        },
        _togglePopup: function (action, timer, currentPopupDelay, currentOverlayDelay, currentContentDelay) {
            var self = this;
            var enable = action === 'enable';

            if (enable) {
                self.settings.callback_beforeOpen();
                self.$wrapper.addClass(_PREFIX + 'active');
                if (self.settings.popup_bodyClass !== '') $('body').addClass(self.settings.popup_bodyClass);
                if (self.settings.popup_wrapperClass !== '') self.$wrapper.addClass(self.settings.popup_wrapperClass);
                if (self.settings.content_loadViaAjax) self._loadContentViaAjax();

                setTimeout (function () {
                    self.settings.callback_afterVisible();
                    if (self.$wrapper.attr('data-sm-autoClose') === 'enable') self.autoClose();
                }, (parseFloat(self.$popup.css('animation-delay')) + parseFloat(self.$popup.css('animation-duration'))) * 1000 + timer);

            } else {
                self.settings.callback_afterClose();
                self.$wrapper.removeClass(_PREFIX + 'active');
                if (self.settings.page_animate) self._pageAnimation('disable');
            }

            setTimeout (function () {
                if (enable) {
                    self.settings.callback_afterOpen();
                    self.$wrapper.show();
                    if (self.$popup[0].style.height === 'auto') self._popupCalculateHeight();
                    if (self.settings.page_animate) self._pageAnimation('enable');
                } else {
                    if (self.settings.overlay_isVisible) self.$overlay.css('animation-delay', currentOverlayDelay);
                    if (self.settings.content_animate) self.$el.css('animation-delay', currentContentDelay);

                    self.$popup.css('animation-delay', currentPopupDelay);
                    self.$wrapper.hide();

                    self.settings.callback_afterHidden();
                    if (self.settings.popup_bodyClass !== '') $('body').removeClass(self.settings.popup_bodyClass);
                    if (self.settings.popup_wrapperClass !== '') self.$wrapper.removeClass(self.settings.popup_wrapperClass);
                    if (self.$wrapper.attr('data-sm-autoClose') === 'enable') clearTimeout(self.autoCloseTimer);
                }

            }, timer);
        },
        _typeController: function (t, v) {

            var self = this;
            var type = t || self.$wrapper.attr('data-sm-type');
            var val  = v || parseFloat(self.$wrapper.attr('data-sm-type-val'));

            switch (true) {

                case (type === 'delayed'):
                    self._togglePopup('enable', ((typeof val === 'string') ? parseFloat(val) : val) * 1000);
                    break;

                case (type === 'scrolled'):
                    var opened = 0;
                    var closed = 0;
                    $(document).on('scroll', function() {
                        var scrollY = $(this).scrollTop();
                        if ((scrollY > val) && !opened) {
                            self._togglePopup('enable', 0);
                            opened = 1;
                        }
                        if (self.settings.popup_scrollHideOnUp && scrollY < val && opened && !closed) {
                            self.closePopup();
                            closed = 1;
                            $(document).unbind('scroll');
                        }
                    });
                    break;

                case (type === 'exit'):
                    var stop = 0;
                    $(document).on('mouseleave', function () {
                        if (!stop) {
                            if (!self.settings.popup_exitShowAlways) {
                                stop = 1;
                                $(document).unbind('mouseleave');
                            }
                            self._togglePopup('enable', 0);
                        }
                    });
                    break;

                case (type === 'instant'):
                    self._togglePopup('enable', 0);
                    break;
            }

        },

        // @public
        openPopup: function (type, val) {
            if (this._wrapperActive()) return _log(_LOG_START + 'This popup instance is already active.');
            if (this._activeInstanceExist()) return;

            this._typeController(type, val);
        },
        closePopup: function () {
            if (!this._wrapperActive()) return _log(_LOG_START + 'Popup is already closed.');

            this.settings.callback_beforeClose();
            this._prepareClose();
            if (this.settings.restrict_cookieSet) this._setCookie();

            if (this.settings.popup_redirectOnClose &&
                this.settings.popup_redirectOnCloseTriggers.indexOf('close') > -1) {
                this._redirectOnClose();
            }
        },
        styleElement: function (scope, props) {
            if (typeof props !== 'object') return _log(_LOG_START + 'Only object with CSS properties' + _LOG_END_1);

            switch (true) {

                case (scope === 'overlay' && this.settings.overlay_isVisible):
                    this.$overlay.css(props);
                    if (this.$popup.length > 0 && props['animation-duration']) {
                        this.$popup.css('animation-delay', parseFloat(props['animation-duration']) / 2 + 's');
                    }
                    break;

                case ((scope === 'popup')):
                    this.$popup.css(props);
                    this._popupPositionCorrect();
                    break;

                case (scope === 'content'):
                    this.$el.css(props);
                    break;
            }
        },
        popupPosition: function (position) {
            if (typeof position !== 'string') return _log(_LOG_START + 'Only string' + _LOG_END_1);

            this.$popup.attr('data-sm-position', position);
            this._popupPositionCorrect();
        },
        setEffect: function (scope, effect) {
            if (typeof scope !== 'string' || typeof effect !== 'string') return _log(_LOG_START + 'Only strings' + _LOG_END_1);

            switch (true) {

                case (scope === 'overlay' && this.settings.overlay_isVisible):
                    this.$overlay.attr('data-sm-effect', effect);
                    break;

                case (scope === 'popup'):
                    this.$popup.attr('data-sm-effect', effect);
                    break;

                case (scope === 'content'):
                    this.$el.attr('data-sm-effect', effect);
                    break;
            }
        },
        setType: function (type, val) {
            this.$wrapper.attr({
                'data-sm-type'    : type,
                'data-sm-type-val': val
            });
        },
        autoClose: function (action, timer) {
            var self = this;
            self.$wrapper.attr({
                'data-sm-autoClose'      : action,
                'data-sm-autoClose-after': timer
            });

            action = action || self.$wrapper.attr('data-sm-autoClose');
            timer  = timer  || self.$wrapper.attr('data-sm-autoClose-after');

            if (action === 'enable') {
                self.autoCloseTimer = setTimeout(function () {
                    self.closePopup();
                }, parseFloat(timer) * 1000);
            }

        },
        destroy: function () {
            $('.' + this.settings.popup_reopenClass).on((this.settings.popup_reopenClassTrigger === 'click') ? 'click' : 'mouseover', function () {
                return false;
            });

            this.$el.remove();
            this.$wrapper.remove();
            this.$overlay.remove();
            this.$popup.remove();

            delete this.$el;
            delete this.$wrapper;
            delete this.$overlay;
            delete this.$popup;
            delete this;
        }
    };

    // Plugin interface
    $.fn[_PLUGIN_NAME] = function (config) {
        var args = Array.prototype.slice.call(arguments, 1);

        return this.each(function () {
            var $el      = $(this);
            var instance = $el.data(_PLUGIN_NAME);

            if (!instance) {
                $el.data(_PLUGIN_NAME, new SlickModals(this, config));
            } else {
                if (typeof config === 'string') {
                    try {
                        instance[config].apply(instance, args);
                    } catch (e) {
                        _log(_LOG_START + 'Method does not exist in Slick Modals.');
                    }
                }
            }
        });
    }

}) (jQuery);
