// Every widget script depends on this one (handle usk-core), so the shared
// helpers for values read from page markup are bundled here.
import "./usk-safe-settings";

(function ($, elementor) {
    ("use strict");

    /**
     * A value read from page markup that a library concatenates into an HTML
     * string inside a double-quoted attribute. The browser decodes the entities
     * again when it parses that string, so the attribute keeps the same text.
     */
    function uskAttributeText(value) {
        if (value === undefined || value === null) {
            return value;
        }
        return String(value).replace(/[&<>"'`]/g, function (character) {
            return "&#" + character.charCodeAt(0) + ";";
        });
    }

    /**
     * Whether a link points to a page of this site. A pagination link is fetched
     * and its response parsed as HTML in the page, so it must come from here.
     */
    function uskIsSameOriginUrl(url) {
        if (typeof url !== "string" || "" === uskSafeUrl(url)) {
            return false;
        }
        try {
            var parsed = new URL(url, window.location.href);
            return /^https?:$/.test(parsed.protocol) && parsed.origin === window.location.origin;
        } catch (e) {
            return false;
        }
    }

    /**
     * The URL a wishlist/compare button links to once its product is added.
     * jQuery turns a JSON-looking value into an array or object, whose string
     * form can still be a "javascript:" URL, so it is checked as a string.
     */
    function uskSafeRedirectUrl(value) {
        if (value === undefined || value === null) {
            return value;
        }
        return uskSafeUrl(String(value));
    }

    $(document).on("click", ".quick_view", function () {
        var product_id = $(this).data("id");
        get_product_details(product_id);
    });

    //woocommerce gallery
    $(document).on("click", ".thumbnails a", function (e) {
        // data-* is not a URL attribute, so KSES keeps "javascript:" in it.
        var img_url = uskSafeUrl($(this).attr("data-href"));
        if (!img_url) {
            return;
        }
        $(".usk-modal-image-wrapper .images > a").attr("href", img_url);
        $(".usk-modal-image-wrapper .images > a > img").attr({
            src: img_url,
            srcset: img_url,
        });
    });
    $(document).on(
        "click",
        ".usk-modal-page .usk-modal-product .images a",
        function (e) {
            e.preventDefault();
            var img_url = uskSafeUrl($(this).attr("data-href"));
            var img_src = $(this).find("img").attr("srcset");
            // $('.woocommerce-main-image').find('img').attr('src', img_url);
            // $('.woocommerce-main-image').find('img').attr('srcset', img_src);
            if (img_url) {
                $(".woocommerce-main-image").closest("a").attr("href", img_url);

                $(".woocommerce-main-image").find("img").attr({
                    src: img_url,
                    srcset: img_src,
                });
            }

            // prettyPhoto renders a link's title and its image's alt, URL-decoded,
            // as HTML, so "%3Cimg onerror%3E" in plain page text becomes markup.
            // Only the gallery of a quick view this script loaded is bound, not
            // every matching link on the page (page content can imitate it).
            var $page = $(this).closest(".usk-modal-page");
            if (!$page.length || !jQuery.data($page[0], "uskQuickViewLoaded")) {
                return;
            }

            $page.find("a.zoom").prettyPhoto({
                hook: "data-rel",
                social_tools: false,
                theme: "pp_woocommerce",
                horizontal_padding: 20,
                opacity: 0.8,
                deeplinking: false,
            });
            $page.find("a[data-rel^='prettyPhoto']").prettyPhoto({
                hook: "data-rel",
                social_tools: false,
                theme: "pp_woocommerce",
                horizontal_padding: 20,
                opacity: 0.8,
                deeplinking: false,
            });
        }
    );

    function get_product_details(product_id) {
        if (product_id !== undefined) {
            jQuery.ajax({
                type: "POST",
                url: ultimate_store_kit_ajax_config.ajaxurl,
                data: {
                    action: "ultimate_store_kit_wc_product_quick_view_content",
                    product_id: product_id,
                },
                success: function (response) {
                    setTimeout(function () {
                        $("#quick-view-id").html(response);
                        // Kept in jQuery's data store, which markup cannot set
                        // (unlike data-* attributes).
                        $("#quick-view-id").find(".usk-modal-page").each(function () {
                            jQuery.data(this, "uskQuickViewLoaded", true);
                        });
                    }, 1000);
                },
            });
        }
    }

    $(".elementor-widget-usk-florence-grid").on(
        "click",
        ".usk-pagination a",
        function (b) {
            const requestUrl = $(this).prop("href");
            // The response is parsed as HTML in this page, so a link to another
            // site (markup imitating the grid in page content) is not fetched;
            // the browser just follows it.
            if (!uskIsSameOriginUrl(requestUrl)) {
                return;
            }
            b.preventDefault();
            $.ajax({
                url: requestUrl,
                success: function (d) {
                    var data = $(d).find(".elementor-widget-usk-florence-grid");
                    $(".elementor-widget-usk-florence-grid").html(data);
                    if (window.history.pushState) {
                        window.history.pushState({}, "", requestUrl);
                    }
                },
            });
        }
    );

    // ========================================
    //                AJAX START
    // ========================================

    $(".ajax_add_to_wishlist:not(.usk-active)").attr("href", "javascript:void(0);");
    $(".ajax_add_to_wishlist").on("click", function (e) {
        // e.preventDefault();
        var $this = $(this),
            $product_id = $this.data("product_id"),
            // Becomes the link's href; data-* keeps "javascript:" through KSES.
            $redirect_url = uskSafeRedirectUrl($this.data("redirect_url")),
            $area_label = $this.data("aria_label");
        $.ajax({
            url: ultimate_store_kit_ajax_config.ajaxurl,
            data: {
                action: "usk_add_to_wishlist",
                product_id: $product_id,
                nonce: ultimate_store_kit_ajax_config.nonce,
            },
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                if (response.action === "added") {
                    $this.addClass("usk-active").attr("aria-label", $area_label);
                    $(".usk-wishlist-button")
                        .find(".usk-wishlist-count")
                        .html(response.count);

                    $this.attr({
                        href: $redirect_url,
                    });
                }
                // else {
                //     $this.removeClass("usk-active").attr("aria-label", response.message);
                //     $this.attr({
                //         href: "javascript:void(0);",
                //     });
                // }
            },
            error: function (response) {
                console.log(response);
            },
        });
    });
    $(".ajax_remove_from_wishlist").on("click", function (e) {
        e.preventDefault();
        var $this = $(this),
            $product_id = $this.data("product_id");
        $.ajax({
            url: ultimate_store_kit_ajax_config.ajaxurl,
            data: {
                action: "usk_remove_wishlist",
                product_id: $product_id,
                nonce: ultimate_store_kit_ajax_config.nonce,
            },
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                if (response.action == "removed") {
                    $this.closest("tr").remove();
                    $(".usk-wishlist-button")
                        .find(".usk-wishlist-count")
                        .html(response.count);
                }
            },
            error: function (response) {
                console.log(response);
            },
        });
    });

    $(".ajax_add_to_compare:not(.usk-active)").attr("href", "javascript:void(0);");
    $(".ajax_add_to_compare").on("click", function (e) {
        var $this = $(this),
            $product_id = $this.data("product_id"),
            // Becomes the link's href; data-* keeps "javascript:" through KSES.
            $redirect_url = uskSafeRedirectUrl($this.data("redirect_url")),
            $area_label = $this.data("aria_label");
        $.ajax({
            url: ultimate_store_kit_ajax_config.ajaxurl,
            data: {
                action: "usk_add_to_compare_products",
                product_id: $product_id,
                nonce: ultimate_store_kit_ajax_config.nonce,
            },
            type: "POST",
            dataType: "JSON",
            success: function (response) {
                if (response.action === "added") {

                    $this.addClass("usk-active").attr("aria-label", $area_label);
                    $(".usk-compare-button")
                        .find(".usk-compare-count")
                        .html(response.count);

                    $this.attr({
                        href: $redirect_url,
                    });
                }
                // else {
                //     $this.attr({
                //         href: "javascript:void(0);",
                //         "aria-label": response.message,
                //     });
                // }
            },
            error: function (response) {
                console.log(response);
            },
        });
    });

    $(".ajax_add_to_cart").on("click", function (e) {
        e.preventDefault();
        var $this = $(this);
        $this.attr("aria-label", "Added to cart");
    });
    // ========================================
    //                AJAX END
    // ========================================
    $(document).ready(function () {
        var loader = `<div class="usk-bouncing-loader"><div></div><div></div><div></div></div>`;
        var width = $(".product-quick-view").data("modal-width");
        var height = $(".product-quick-view").data("modal-height");
        var animation = $(".product-quick-view").data("animation");
        var close_btn = $(".product-quick-view").data("close-btn");
        // SlickModals builds its close button by concatenating these two into an
        // HTML string, and the first .product-quick-view in the document may be
        // page content, not the modal the plugin prints in the footer.
        var btn_style = uskAttributeText($(".product-quick-view").data("btn-style"));
        // var btn_place   = $('.product-quick-view').data('btn-place');
        var btn_text = uskAttributeText($(".product-quick-view").data("btn-text"));
        var modal_bg = $(".product-quick-view").data("modal-bg");
        var modal_overlay = $(".product-quick-view").data("modal-overlay");
        $(".product-quick-view").SlickModals({
            popup_reopenClass: "quick_view",
            popup_animation: animation,
            overlay_animation: animation,
            popup_closeButtonEnable: close_btn,
            popup_closeButtonStyle: btn_style,
            popup_closeButtonText: btn_text,
            popup_closeButtonPlace: "inside",
            popup_css: {
                width: width ? width + "px" : "800px",
                height: height ? height + "px" : "450px",
                background: modal_bg ? modal_bg : "#fff",
                "overflow-y": "auto",
                "animation-duration": "0.7s",
            },
            overlay_css: {
                background: modal_overlay,
            },
            mobile_breakpoint: "768px",
            mobile_position: "center",
            mobile_css: {
                width: "300px",
                padding: "30px",
                margin: "20px",
            },
            callback_afterClose: function () {
                $("#quick-view-id").html(loader);
            },
            callback_beforeOpen: function () {
                $("#quick-view-id").html(loader);
            },
        });
    });

    // Each time quantity in the cart changes, trigger update
    // cart option
    jQuery(".usk-page-cart div.woocommerce").on("change", ".qty", function () {
        var $form = jQuery(this).closest(".woocommerce-cart-form");
        var $updateButton = $form.find("[name='update_cart']");

        $updateButton.prop("disabled", false);
        $updateButton.trigger("click");
    });
})(jQuery, window.elementorFrontend);
