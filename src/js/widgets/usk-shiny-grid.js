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

  // Handle tab click events
  function setupTabClickHandlers() {
    $(".tab-option")
      .off("click")
      .on("click", function () {
        const gridColumn = $(this).data("grid-column");
        // Use sessionStorage instead of localStorage to persist across page loads
        localStorage.setItem("usk_grid_data", gridColumn);
        updateActiveTab($(this));
        updateGridLayout($(this), gridColumn);
      });
  }

  // Update which tab is active
  function updateActiveTab($clickedTab) {
    const $header = $clickedTab.closest(".usk-grid-header");
    $header.find("li").removeClass("usk-tabs-active");
    $clickedTab.parent().addClass("usk-tabs-active");
  }

  // Update the grid layout based on selected tab
  function updateGridLayout($clickedTab, gridColumn) {
    const $grid = $clickedTab.closest(".usk-grid-header").parent().find(".usk-grid");
    const baseClass = gridColumn !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
    $grid.removeClass().addClass(baseClass + " " + gridColumn);
  }

  // Load saved grid layout from localStorage
  function loadSavedGridLayout($element) {
    // Remove the elementor.isEditMode() check to ensure it works in all modes
    const savedGridData = localStorage.getItem("usk_grid_data");
    if (savedGridData) {
      // Find the tab with the saved grid column and make it active
      const $tab = $("[data-grid-column='" + savedGridData + "']");
      if ($tab.length) {
        $tab.parent().addClass("usk-tabs-active");
        const baseClass = savedGridData !== "usk-list-2" ? "usk-grid usk-grid-layout" : "usk-grid usk-list-layout";
        $element.find(".usk-grid").removeClass().addClass(baseClass + " " + savedGridData);
      }
    }
  }

  // ===== PRODUCT VARIATION FUNCTIONALITY =====
  function setupVariationButtons($scope) {
    $scope.find(".usk-variation-button").off("click").on("click", function (e) {
      e.preventDefault();
      const $this = $(this);
      const productId = $this.data("product-id");
      const attribute = $this.data("attribute");
      const value = $this.data("value");
      const variationId = $this.data("variation-id");
      const $productContainer = $(`.usk-item[data-product-id="${productId}"]`);

      // Check if already active - toggle selection for optional attributes
      if ($this.hasClass("active")) {
        // Don't allow deselection if this is the only selected attribute
        const selectedCount = $productContainer.find(".usk-variation-button.active").length;
        if (selectedCount > 1) {
          $this.removeClass("active");
          // Update add to cart button with remaining selected attributes
          const remainingAttributes = collectSelectedAttributes($productContainer);
          if (Object.keys(remainingAttributes).length > 0) {
            updateAddToCartButton($productContainer, productId, null, remainingAttributes);
          } else {
            // If no attributes selected, reset the button to "Select options"
            resetButtonToSelectOptions($productContainer);
          }
          return;
        }
      }

      updateActiveVariation($this, productId, attribute);
      const allAttributes = collectSelectedAttributes($productContainer);

      // Only update add to cart if we have at least one attribute selected
      if (Object.keys(allAttributes).length > 0) {
        updateAddToCartButton($productContainer, productId, variationId, allAttributes);
      }

      // Handle color variations specially
      if (attribute === "pa_color") {
        updateProductImage(productId, variationId, $productContainer);
        storeSelectedColor($this, value, $productContainer);
      }
    });
  }

  // Reset button to "Select options" state
  function resetButtonToSelectOptions($productContainer) {
    const $addToCartBtn = $productContainer.find(".usk-button");
    if (!$addToCartBtn.length) return;

    // Clear attributes
    $.each($addToCartBtn[0].attributes, function () {
      if (this.name.indexOf("data-attribute_") === 0) {
        $addToCartBtn.removeAttr(this.name);
      }
    });

    // Reset button
    $addToCartBtn
      .removeClass("add_to_cart_button product_type_variation")
      .addClass("product_type_variable")
      .attr("href", "javascript:void(0)")
      .removeAttr("data-variation_id")
      .html('Select options <i class="button-icon usk-icon-arrow-right-8"></i>');
  }

  // Update which variation is active
  function updateActiveVariation($button, productId, attribute) {
    $(`.usk-variation-button[data-attribute="${attribute}"][data-product-id="${productId}"]`).removeClass("active");
    $button.addClass("active");
  }

  // Collect all selected attributes for a product
  function collectSelectedAttributes($productContainer) {
    const allAttributes = {};
    $productContainer.find(".usk-variation-button.active").each(function () {
      allAttributes[$(this).data("attribute")] = $(this).data("value");
    });
    return allAttributes;
  }

  // Update the add to cart button with variation data
  function updateAddToCartButton($productContainer, productId, variationId, allAttributes) {
    const $addToCartBtn = $productContainer.find(".usk-button");
    if (!$addToCartBtn.length) return;

    // Clear previous attributes
    $.each($addToCartBtn[0].attributes, function () {
      if (this.name.indexOf("data-attribute_") === 0) {
        $addToCartBtn.removeAttr(this.name);
      }
    });

    // Find the correct variation ID for the selected attributes combination
    let finalVariationId = variationId;

    // If we have multiple attributes selected, we need to find the correct variation ID
    if (Object.keys(allAttributes).length > 1) {
      findCorrectVariation($productContainer, allAttributes, productId).then(correctVariationId => {
        if (correctVariationId) {
          finalVariationId = correctVariationId;

          // Update button attributes with the correct variation ID
          updateButtonAttributes($addToCartBtn, productId, finalVariationId, allAttributes);
        }
      });
    } else {
      // If only one attribute is selected, just use the provided variation ID
      updateButtonAttributes($addToCartBtn, productId, finalVariationId, allAttributes);
    }
  }

  // Helper function to update button attributes
  function updateButtonAttributes($button, productId, variationId, attributes) {
    // Set base attributes
    $button.attr({
      "data-variation_id": variationId,
      "data-product_id": productId,
      href: "javascript:void(0)",
    });

    // Add attribute data
    Object.keys(attributes).forEach(attr => {
      $button.attr(`data-attribute_${attr}`, attributes[attr]);
    });

    // Update button classes
    $button
      .addClass("add_to_cart_button product_type_variation")
      .removeClass("product_type_variable")
      .html('Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>');
  }

  // Function to find the correct variation ID for a combination of attributes
  function findCorrectVariation($productContainer, selectedAttributes, productId) {
    return new Promise((resolve) => {
      $.ajax({
        url: woocommerce_params.ajax_url,
        type: "POST",
        data: {
          action: "usk_find_variation",
          product_id: productId,
          attributes: selectedAttributes
        },
        success: function(response) {
          if (response.success && response.data.variation_id) {
            resolve(response.data.variation_id);
          } else {
            resolve(null);
          }
        },
        error: function() {
          resolve(null);
        }
      });
    });
  }

  // Update product image for color variations
  function updateProductImage(productId, variationId, $productContainer) {
    $.ajax({
      url: woocommerce_params.ajax_url,
      type: "POST",
      data: {
        action: "get_variation_data",
        product_id: productId,
        variation_id: variationId,
      },
      success: function (response) {
        if (response.success && response.data?.image?.src) {
          $productContainer.find(".image-default, .image-hover").attr("src", response.data.image.src);
        }
      },
    });
  }

  // Store selected color information
  function storeSelectedColor($button, value, $productContainer) {
    const bgColor = $button.css("background-color");
    if (bgColor && bgColor !== "transparent" && bgColor !== "rgba(0, 0, 0, 0)") {
      $productContainer.attr("data-selected-color", value);
    }
  }

  // ===== ADD TO CART FUNCTIONALITY =====
  function setupAddToCartButtons() {
    // Remove any existing click handlers to prevent duplicates
    $(document.body).off("click", ".usk-shiny-grid .usk-button.product_type_variation");

    // Add the click handler
    $(document.body).on("click", ".usk-shiny-grid .usk-button.product_type_variation", function (e) {
      e.preventDefault();

      const $button = $(this);
      if ($button.hasClass("processing")) return false;

      $button.addClass("processing loading");

      // Check for required data
      if (!$button.data("variation_id") || !$button.data("product_id")) {
        $button.removeClass("processing loading");
        return true;
      }

      const data = prepareCartData($button);
      sendAddToCartRequest($button, data);
      return false;
    });
  }

  // Prepare data for add to cart request
  function prepareCartData($button) {
    const data = {
      product_id: $button.data("product_id"),
      variation_id: $button.data("variation_id"),
      quantity: $button.data("quantity") || 1,
      "add-to-cart": $button.data("product_id"),
    };

    // Add attribute data
    $.each($button[0].attributes, function () {
      if (this.name.startsWith("data-attribute_")) {
        data[this.name.substring(5)] = this.value;
      }
    });

    return data;
  }

  // Send AJAX request to add product to cart
  function sendAddToCartRequest($button, data) {
    // Collect all attributes data
    const attributes = {};
    $.each($button[0].attributes, function() {
      if (this.name.startsWith("data-attribute_")) {
        const attrName = this.name.replace("data-", "");
        attributes[attrName] = this.value;
      }
    });

    // Format the data properly for the AJAX request
    const ajaxData = {
      action: "usk_add_to_cart",
      nonce: usk_ajax_config.nonce,
      product_id: data.product_id,
      variation_id: data.variation_id,
      quantity: data.quantity || 1
    };

    // Add the attributes to the request
    Object.assign(ajaxData, attributes);

    console.log("Sending data:", ajaxData);

    $.ajax({
      url: usk_ajax_config.ajax_url, // Use the localized AJAX URL
      type: "POST",
      data: ajaxData,
      cache: false, // Prevent caching of AJAX requests
      success: function (response) {
        console.log("Success response:", response);
        $button.removeClass("loading");

        if (!response || response.error) {
          console.error("Error response:", response);
          $button.removeClass("processing");
          return;
        }

        // Trigger WooCommerce cart update
        $(document.body).trigger("wc_fragment_refresh");
        $(document.body).trigger("added_to_cart");

        // Show success message
        const $notification = $(
          '<div class="usk-cart-success-message">Product added to cart! ✓</div>'
        );
        $button.closest(".usk-item").append($notification);

        setTimeout(function () {
          $notification.fadeOut(300, function () {
            $(this).remove();
            $button.removeClass("processing");

            // Reset button state for future add to cart events
            resetAddToCartButtonState($button);
          });
        }, 2000);
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", xhr.responseText);
        console.error("Status:", status);
        console.error("Error:", error);
        $button.removeClass("loading processing");
      },
      complete: function() {
        // Ensure button state is reset even if there's an unexpected error
        setTimeout(function() {
          $button.removeClass("loading processing");
        }, 2500);
      }
    });
  }

  // Reset add to cart button state for future add to cart events
  function resetAddToCartButtonState($button) {
    // Preserve the original attributes but ensure they're still valid
    const productId = $button.data("product_id");
    const variationId = $button.data("variation_id");

    // Find the corresponding product container
    const $productContainer = $(`.usk-item[data-product-id="${productId}"]`);

    // Re-collect the current selected attributes to ensure they're fresh
    const currentAttributes = collectSelectedAttributes($productContainer);

    // Only update if we have valid attributes
    if (Object.keys(currentAttributes).length > 0) {
      // Verify the variation ID is still valid with the data store
      findCorrectVariation($productContainer, currentAttributes, productId).then(correctVariationId => {
        if (correctVariationId) {
          // Update with fresh data
          updateButtonAttributes($button, productId, correctVariationId, currentAttributes);
        }
      });
    }
  }

  // ===== MAIN INITIALIZATION FUNCTION =====
  function initializeGridFunctionality($scope) {
    setupGridFilter($scope);
    setupVariationButtons($scope);
    setupAddToCartButtons();

    // Reset any processing buttons on initialization
    $scope.find('.usk-button.processing').removeClass('processing');
  }

  // Initialize on element ready
  function GridColumn($scope) {
    initializeGridFunctionality($scope);
  }

  // Listen for cart changes to update buttons
  $(document.body).on('added_to_cart removed_from_cart wc_fragments_refreshed', function() {
    // This helps maintain proper state after cart operations
    setTimeout(function() {
      // Clear all processing states
      $('.usk-button.processing').removeClass('processing');

      // Reset any add to cart buttons that might be in an invalid state
      $('.usk-variations-container').each(function() {
        const $container = $(this);
        const productId = $container.data('product-id');
        const $productItem = $(`.usk-item[data-product-id="${productId}"]`);

        if ($productItem.length) {
          const $addToCartBtn = $productItem.find('.usk-button');
          const selectedAttributes = collectSelectedAttributes($productItem);

          if (Object.keys(selectedAttributes).length > 0) {
            // Find correct variation ID for selected attributes
            findCorrectVariation($productItem, selectedAttributes, productId).then(correctVariationId => {
              if (correctVariationId) {
                // Update with fresh data
                updateButtonAttributes($addToCartBtn, productId, correctVariationId, selectedAttributes);
              }
            });
          }
        }
      });
    }, 500);
  });

  // Re-initialize after AJAX content is loaded
  $(document).ajaxComplete(function (event, xhr) {
    if (
      xhr.responseText &&
      (xhr.responseText.indexOf("usk-shiny-grid") > -1 ||
       xhr.responseText.indexOf("usk-variation-button") > -1 ||
       xhr.responseText.indexOf("usk-grid") > -1)
    ) {
      initializeGridFunctionality($(document));
    }
  });

  // Register with Elementor
  $(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/usk-shiny-grid.default",
      GridColumn
    );
  });
})(jQuery, window.elementorFrontend);
