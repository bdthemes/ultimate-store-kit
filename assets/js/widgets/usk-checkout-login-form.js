;(function ($, elementor) {
  $(window).on('elementor/frontend/init', function () {
    let ModuleHandler = elementorModules.frontend.handlers.Base,
      CheckoutLoginForm

    CheckoutLoginForm = ModuleHandler.extend({
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
        var $container = this.$element.find(".usk-checkout-login-form");
        if (!$container.length) {
          return;
        }
        	var wc_checkout_login_form = {
            init: function () {
              $($container).on("click", "a.showlogin", this.show_login_form);
            },
            show_login_form: function () {
              $("form.login, form.woocommerce-form--login").slideToggle();
              return false;
            },
          };
          wc_checkout_login_form.init();
      }


    })

    elementorFrontend.hooks.addAction(
      'frontend/element_ready/usk-checkout-login-form.default',
      function ($scope) {
        elementorFrontend.elementsHandler.addHandler(CheckoutLoginForm, {
          $element: $scope
        })
      }
    )
  })
})(jQuery, window.elementorFrontend)
