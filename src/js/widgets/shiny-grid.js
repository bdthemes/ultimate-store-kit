(function ($, elementor) {
  "use strict";

  // ===== GRID FILTER FUNCTIONALITY =====
  function setupGridFilter($scope) {
    $scope.find('*[data-filter="yes"]').each(function () {
      const $element = $(this);
      setupTabClickHandlers();
      loadSavedGridLayout($element);
    });
  }

  function setupTabClickHandlers() {
    $(".tab-option")
      .off("click")
      .on("click", function () {
        const gridColumn = $(this).data("grid-column");
        localStorage.setItem("usk_grid_data", gridColumn);
        updateActiveTab($(this));
        updateGridLayout($(this), gridColumn);
      });
  }

  function updateActiveTab($clickedTab) {
    const $header = $clickedTab.closest(".usk-grid-header");
    $header.find("li").removeClass("usk-tabs-active");
    $clickedTab.parent().addClass("usk-tabs-active");
  }

  function updateGridLayout($clickedTab, gridColumn) {
    const $grid = $clickedTab.closest(".usk-grid-header").parent().find(".usk-grid");
    const baseClass = gridColumn !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
    $grid.removeClass().addClass(baseClass + " " + gridColumn);
  }

  function loadSavedGridLayout($element) {
    const savedGridData = localStorage.getItem("usk_grid_data");
    if (savedGridData) {
      const $tab = $("[data-grid-column='" + savedGridData + "']");
      if ($tab.length) {
        $tab.parent().addClass("usk-tabs-active");
        const baseClass = savedGridData !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
        $element.find(".usk-grid").removeClass().addClass(baseClass + " " + savedGridData);
      }
    }
  }


  // ===== ELEMENTOR INTEGRATION =====
  $(window).on("elementor/frontend/init", function () {
    // Register widgets
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-shiny-grid.default", setupGridFilter);
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-glossy-grid.default", setupGridFilter);
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-florence-grid.default", setupGridFilter);

    // Setup add to cart handling for variations
    setupVariationAddToCart();
  });

  // Handle variation add to cart
  function setupVariationAddToCart() {
    // Remove any existing handlers to prevent duplicates
    $(document.body).off('click.uskVariationAddToCart', '.usk-button.product_type_variation.add_to_cart_button');

    // Remove WooCommerce's default click handler that might be causing redirects
    $(document.body).off('click', '.add_to_cart_button');

    // Remove href attributes from all variation buttons to prevent default browser navigation
    $('.usk-button.product_type_variation.add_to_cart_button').each(function() {
      $(this).attr('href', 'javascript:void(0)');
      $(this).attr('data-prevent_redirect', 'true');
    });

    // Add handler for variation add to cart buttons
    $(document.body).on('click.uskVariationAddToCart', '.usk-button.product_type_variation.add_to_cart_button', function(e) {
      // Always prevent default action to avoid redirect
      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      const $button = $(this);

      // Remove href to prevent any chance of redirect
      $button.attr('href', 'javascript:void(0)');

      const productId = $button.data('product_id');
      const variationId = $button.data('variation_id');

      if (!productId || !variationId) {
        console.log('Missing product ID or variation ID');
        return false; // Don't proceed without required data
      }

      // Prepare data for AJAX add to cart
      const data = {
        product_id: productId,
        variation_id: variationId,
        quantity: 1
      };

      // Add all attributes
      $.each($button[0].attributes, function(i, attr) {
        if (attr.name.startsWith('data-attribute_')) {
          const attrName = attr.name.substring(5); // Remove 'data-'
          data[attrName] = attr.value;
        }
      });

      // Add the loading class
      $button.addClass('loading');

      // Send AJAX request
      $.ajax({
        type: 'POST',
        url: usk_ajax_config.ajax_url,
        data: {
          action: 'usk_add_to_cart',
          nonce: usk_ajax_config.nonce,
          ...data
        },
        success: function(response) {
          $button.removeClass('loading');

          if (response.success) {
            // Update fragments
            if (response.fragments) {
              $.each(response.fragments, function(key, value) {
                $(key).replaceWith(value);
              });
            }

            // Trigger events for WC compatibility
            $(document.body).trigger('wc_fragment_refresh');
            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);

            // Show success message
            const $notification = $('<div class="usk-cart-success-message">Product added to cart! ✓</div>');
            $button.closest(".usk-item").append($notification);

            setTimeout(function() {
              $notification.fadeOut(300, function() {
                $(this).remove();
              });
            }, 2000);
          } else {
            console.error('Error adding to cart:', response);
            alert(response.message || 'Error adding product to cart');
          }
        },
        error: function() {
          $button.removeClass('loading');
          alert('Error occurred while adding to cart. Please try again.');
        },
        complete: function() {
          // Ensure the href is still void to prevent any redirects
          $button.attr('href', 'javascript:void(0)');
        }
      });

      return false;
    });

    // Also handle any dynamically added buttons
    $(document.body).on('wc_fragments_refreshed wc_fragments_loaded added_to_cart', function() {
      $('.usk-button.product_type_variation.add_to_cart_button').each(function() {
        $(this).attr('href', 'javascript:void(0)');
        $(this).attr('data-prevent_redirect', 'true');
      });
    });
  }
})(jQuery, window.elementorFrontend);
