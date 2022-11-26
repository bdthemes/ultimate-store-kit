(function ($, elementor) {
  $(window).on("elementor/frontend/init", function () {
    let ModuleHandler = elementorModules.frontend.handlers.Base, MiniCart;
      var debounce = function(func, wait, immediate) {
      var timeout;
      return function() {
          var context = this,
              args = arguments;
          var callNow = immediate && !timeout;
          clearTimeout(timeout);
          timeout = setTimeout(function() {
              timeout = null;
              if (!immediate) {
                  func.apply(context, args);
              }
          }, wait);
          if (callNow) func.apply(context, args);
      };
  };
    MiniCart = ModuleHandler.extend({
      bindEvents: function () {
        this.run();
      },
      getDefaultSettings: function () {
        return {
          allowHTML: true,
        };
      },

      onElementChange: debounce(function (prop) {
          if (prop.indexOf('usk_mini_cart') !== -1) {
              this.run();
          }
      }, 400),

      settings: function (key) {
        return this.getElementSettings("usk_mini_cart_" + key);
      },


      run: function (key) {
        var options = this.getDefaultSettings();
        var element = this.findElement(".elementor-widget-container").get(0);
        if (jQuery(this.$element).hasClass("elementor-section")) {
          element = this.$element.get(0);
        }
        var $container = this.$element.find(".usk-mini-cart-toggle-btn");
        var $offcanvas = this.$element.find(".usk-mini-cart");
        if (!$container.length) {
          return;
        }
        var MiniCart_ID = "usk-mini-cart-" + this.$element.data("id");
        options = $($container).data("settings");
        toolslide("#" + MiniCart_ID, {
          toggleButton: options.toggleButton,
          position: (this.settings("position") !== undefined) ? this.settings('position') : 'right',
          height: (this.settings('height.size') !== undefined) ? this.settings('height.size') + this.settings('height.unit'): '100%',
          width: (this.settings('width.size') !== undefined) ? this.settings('width.size') + this.settings('width.unit'): '340px',
          closeable: (this.settings('closeable') === 'yes') ? true: false,
          startOpen: (this.settings('startOpen') === 'yes') ? true: false,
          autoclose: (this.settings('autoclose') === 'yes') ? true: false,
          autocloseDelay: (this.settings('autocloseDelay')) ? this.settings('autocloseDelay'): 5000,
          clickOutsideToClose: (this.settings('clickOutsideToClose') === 'yes') ? true: false,

          animations: {
            replace: "crossfade 0.5s ease-in-out",
            toggle: "slide 0.5s ease",
          },
          // listeners: {
          //   afterClose: function () {
          //     $("body").removeClass("usk-mini-cart-opened");
          //   },
          //   beforeOpen: function () {
          //     $("body").addClass("usk-mini-cart-opened");
          //   },
          // },
        });
        $($offcanvas).appendTo("body");
      },
    });

    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-mini-cart.default",
      function ($scope) {
        elementorFrontend.elementsHandler.addHandler(MiniCart, {
          $element: $scope,
        });
      }
    );
  });
})(jQuery, window.elementorFrontend);
