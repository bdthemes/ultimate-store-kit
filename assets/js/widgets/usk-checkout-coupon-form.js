;(function ($, elementor) {
  $(window).on('elementor/frontend/init', function () {
    let ModuleHandler = elementorModules.frontend.handlers.Base,
      MiniCart

    MiniCart = ModuleHandler.extend({
      bindEvents: function () {
        this.run()
      },
      getDefaultSettings: function () {
        return {
          allowHTML: true
        }
      },

      // onElementChange: debounce(function (prop) {
      //     if (prop.indexOf('usk_mini_cart') !== -1) {
      //         this.run();
      //     }
      // }, 400),

      settings: function (key) {
        return this.getElementSettings('usk_mini_cart_' + key)
      },

      run: function (key) {
        var options = this.getDefaultSettings()
        var element = this.findElement('.elementor-widget-container').get(0)
        if (jQuery(this.$element).hasClass('elementor-section')) {
          element = this.$element.get(0)
        }
        var $container = this.$element.find(".usk-checkout-coupon-form");
        if (!$container.length) {
          return;
        }
        var usk_checkout_coupons = {
          init: function () {
            $(document.body).on(
              'click',
              '.usk-checkout-coupon-form a.showcoupon',
              this.show_coupon_form
            )
            $(':is(.usk-checkout-coupon-form .usk-coupon-form,.usk-checkout-coupon-form .checkout_coupon) button[name="apply_coupon"]'
            ).on('click', this.submit)
          },

          show_coupon_form: function (event) {
            event.preventDefault()

            $('.usk-coupon-form').slideToggle(400, function () {
              $('.usk-coupon-form')
                .find(':input:eq(0)')
                .trigger('focus')
            })

            return false
          },

          submit: function (event) {
            event.preventDefault()

            var $form = $('.usk-checkout-coupon-form').find('.usk-coupon-form')
            if ($form.length === 0) {
              $form = $('.usk-checkout-coupon-form').find('.checkout_coupon')
            }

            if ($form.is('.processing')) {
              return false
            }

            $form.addClass('processing').block({
              message: null,
              overlayCSS: {
                background: '#fff',
                opacity: 0.6
              }
            })

            var data = {
              security: wc_checkout_params.apply_coupon_nonce,
              coupon_code: $form.find('input[name="coupon_code"]').val()
            }

            $.ajax({
              type: 'POST',
              url: wc_checkout_params.wc_ajax_url
                .toString()
                .replace('%%endpoint%%', 'apply_coupon'),
              data: data,
              success: function (code) {
                $('.woocommerce-error, .woocommerce-message').remove()
                $form.removeClass('processing').unblock()

                if (code) {
                    $('.usk-checkout-coupon-form').before(code)
                    $form.slideUp()

                  $(document.body).trigger('applied_coupon_in_checkout', [
                    data.coupon_code
                  ])
                  $(document.body).trigger('update_checkout', {
                    update_shipping_method: false
                  })
                }
              },
              dataType: 'html'
            })

            return false
          }
        }
        usk_checkout_coupons.init();
      }
    })

    elementorFrontend.hooks.addAction(
      'frontend/element_ready/usk-checkout-coupon-form.default',
      function ($scope) {
        elementorFrontend.elementsHandler.addHandler(MiniCart, {
          $element: $scope
        })
      }
    )
  })
})(jQuery, window.elementorFrontend)
