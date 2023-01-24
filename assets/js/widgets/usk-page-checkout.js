; (function ($, elementor) {
    $(window).on('elementor/frontend/init', function () {
        let ModuleHandler = elementorModules.frontend.handlers.Base,
            ShippingForm
        ShippingForm = ModuleHandler.extend({
            bindEvents: function () {
                this.run()
            },
            run: function (key) {
                var element = this.findElement('.elementor-widget-container').get(0);
                if (jQuery(this.$element).hasClass('elementor-section')) {
                    element = this.$element.get(0)
                }
                var $container = this.$element.find(".usk-page-checkout");
                if (!$container.length) {
                    return;
                }
                var usk_shipping_form = {
                    $checkout_form: $('.usk-page-checkout'),
                    init: function () {
                        this.$checkout_form.on('change', '#ship-to-different-address input', this.ship_to_different_address);
                        this.$checkout_form.find('#ship-to-different-address input').trigger('change');
                    },
                    ship_to_different_address: function () {
                        $('div.shipping_address').hide();
                        if ($(this).is(':checked')) {
                            $('div.shipping_address').slideDown();
                        }
                    },
                };
                usk_shipping_form.init();
            }
        })
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/usk-page-checkout.default',
            function ($scope) {
                elementorFrontend.elementsHandler.addHandler(ShippingForm, {
                    $element: $scope
                })
            }
        )
    })
})(jQuery, window.elementorFrontend)
