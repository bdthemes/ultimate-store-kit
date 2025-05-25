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

      // Reset states
      $productContainer.find(".usk-button").removeClass("processing loading");

      // Handle toggle selection
      if ($this.hasClass("active")) {
        const selectedCount = $productContainer.find(".usk-variation-button.active").length;
        if (selectedCount > 1) {
          $this.removeClass("active");
          const remainingAttributes = collectSelectedAttributes($productContainer);
          if (Object.keys(remainingAttributes).length > 0) {
            updateAddToCartButton($productContainer, productId, null, remainingAttributes);
          } else {
            resetButtonToSelectOptions($productContainer);
          }
          return;
        }
      }

      // Update selection and button
      updateActiveVariation($this, productId, attribute);
      const allAttributes = collectSelectedAttributes($productContainer);

      if (Object.keys(allAttributes).length > 0) {
        updateAddToCartButton($productContainer, productId, variationId, allAttributes);
      }

      updateProductImage(productId, variationId, $productContainer);
    });
  }

  function updateActiveVariation($button, productId, attribute) {
    $(`.usk-variation-button[data-attribute="${attribute}"][data-product-id="${productId}"]`).removeClass("active");
    $button.addClass("active");
  }

  function collectSelectedAttributes($productContainer) {
    const allAttributes = {};
    $productContainer.find(".usk-variation-button.active").each(function () {
      allAttributes[$(this).data("attribute")] = $(this).data("value");
    });
    return allAttributes;
  }

  function resetButtonToSelectOptions($productContainer) {
    const $addToCartBtn = $productContainer.find(".usk-button");
    if (!$addToCartBtn.length) return;

    // Clear attributes
    if ($addToCartBtn[0] && $addToCartBtn[0].attributes) {
      Array.from($addToCartBtn[0].attributes).forEach(attr => {
        if (attr.name.indexOf("data-attribute_") === 0) {
          $addToCartBtn.removeAttr(attr.name);
        }
      });
    }

    // Reset button
    $addToCartBtn
      .removeClass("add_to_cart_button product_type_variation loading processing")
      .addClass("product_type_variable")
      .attr("href", "javascript:void(0)")
      .removeAttr("data-variation_id")
      .html('Select options <i class="button-icon usk-icon-arrow-right-8"></i>');
  }

  function updateAddToCartButton($productContainer, productId, variationId, allAttributes) {
    const $addToCartBtn = $productContainer.find(".usk-button");
    if (!$addToCartBtn.length) return;

    // Clear existing attributes
    if ($addToCartBtn[0] && $addToCartBtn[0].attributes) {
      Array.from($addToCartBtn[0].attributes).forEach(attr => {
        if (attr.name.indexOf("data-attribute_") === 0) {
          $addToCartBtn.removeAttr(attr.name);
        }
      });
    }

    // Reset states
    $addToCartBtn.removeClass("loading processing");

    let finalVariationId = variationId;

    if (Object.keys(allAttributes).length > 1 || !finalVariationId) {
      findCorrectVariation($productContainer, allAttributes, productId)
        .then(correctVariationId => {
          if (correctVariationId) {
            finalVariationId = correctVariationId;
            updateButtonAttributes($addToCartBtn, productId, finalVariationId, allAttributes);
          }
        })
        .catch(error => {
          // Silent fail
        });
    } else {
      updateButtonAttributes($addToCartBtn, productId, finalVariationId, allAttributes);
    }
  }

  function updateButtonAttributes($button, productId, variationId, attributes) {
    if (!$button || !$button.length || !productId || !variationId) {
      return;
    }

    // Reset states
    $button.removeClass("loading processing");

    // Set attributes
    $button.attr({
      "data-variation_id": variationId,
      "data-product_id": productId,
      href: "javascript:void(0)",
    });

    // Add variation attributes
    if (attributes && typeof attributes === 'object') {
      Object.keys(attributes).forEach(attr => {
        if (attributes[attr]) {
          $button.attr(`data-attribute_${attr}`, attributes[attr]);
        }
      });
    }

    // Update appearance
    $button
      .addClass("add_to_cart_button product_type_variation")
      .removeClass("product_type_variable")
      .html('Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>');
  }

  function findCorrectVariation($productContainer, selectedAttributes, productId) {
    return new Promise((resolve) => {
      if (!productId || !selectedAttributes || Object.keys(selectedAttributes).length === 0 ||
          !woocommerce_params || !woocommerce_params.ajax_url) {
        resolve(null);
        return;
      }

      $.ajax({
        url: woocommerce_params.ajax_url,
        type: "POST",
        data: {
          action: "usk_find_variation",
          product_id: productId,
          attributes: selectedAttributes
        },
        success: function(response) {
          if (response && response.success && response.data && response.data.variation_id) {
            resolve(response.data.variation_id);
          } else {
            resolve(null);
          }
        },
        error: function() {
          resolve(null);
        },
        timeout: 5000
      });
    });
  }

  function updateProductImage(productId, variationId, $productContainer) {
    if (!productId || !variationId || !$productContainer || !$productContainer.length) {
      return;
    }

    $.ajax({
      url: woocommerce_params.ajax_url,
      type: "POST",
      data: {
        action: "get_variation_data",
        product_id: productId,
        variation_id: variationId,
      },
      success: function (response) {
        if (response && response.success && response.data?.image?.src) {
          $productContainer.find(".image-default, .image-hover").attr("src", response.data.image.src);
        }
      }
    });
  }

  // ===== ADD TO CART FUNCTIONALITY =====
  function setupAddToCartButtons() {
    $(document.body).off("click", ".usk-shiny-grid .usk-button.product_type_variation");
    $(document.body).on("click", ".usk-shiny-grid .usk-button.product_type_variation", function (e) {
      e.preventDefault();

      const $button = $(this);
      $button.removeClass("processing");

      if ($button.hasClass("loading")) return false;
      $button.addClass("loading");

      if (!$button.data("variation_id") || !$button.data("product_id")) {
        $button.removeClass("loading");
        return true;
      }

      sendAddToCartRequest($button, prepareCartData($button));
      return false;
    });
  }

  function prepareCartData($button) {
    const data = {
      product_id: $button.data("product_id"),
      variation_id: $button.data("variation_id"),
      quantity: $button.data("quantity") || 1,
      "add-to-cart": $button.data("product_id"),
    };

    if ($button[0] && $button[0].attributes) {
      $.each($button[0].attributes, function () {
        if (this.name && this.name.startsWith("data-attribute_")) {
          data[this.name.substring(5)] = this.value;
        }
      });
    }

    return data;
  }

  function sendAddToCartRequest($button, data) {
    // Collect attributes
    const attributes = {};
    if ($button[0] && $button[0].attributes) {
      $.each($button[0].attributes, function() {
        if (this.name && this.name.startsWith("data-attribute_")) {
          const attrName = this.name.replace("data-", "");
          attributes[attrName] = this.value;
        }
      });
    }

    // Prepare request data
    const ajaxData = {
      action: "usk_add_to_cart",
      nonce: usk_ajax_config.nonce,
      product_id: data.product_id,
      variation_id: data.variation_id,
      quantity: data.quantity || 1
    };

    Object.assign(ajaxData, attributes);

    // Send request
    $.ajax({
      url: usk_ajax_config.ajax_url,
      type: "POST",
      data: ajaxData,
      cache: false,
      success: function (response) {
        $button.removeClass("loading");

        if (!response || response.error) {
          $button.removeClass("processing");
          return;
        }

        // Update cart
        $(document.body).trigger("wc_fragment_refresh");
        $(document.body).trigger("added_to_cart");

        // Show success message
        const $notification = $('<div class="usk-cart-success-message">Product added to cart! ✓</div>');
        $button.closest(".usk-item").append($notification);

        setTimeout(function () {
          $notification.fadeOut(300, function () {
            $(this).remove();
            $button.removeClass("processing");
          });
        }, 2000);
      },
      error: function () {
        $button.removeClass("loading processing");
      },
      complete: function() {
        setTimeout(function() {
          $button.removeClass("loading processing");
        }, 2500);
      }
    });
  }

  // ===== INITIALIZATION & EVENT HANDLING =====
  function initializeGridFunctionality($scope) {
    setupGridFilter($scope);
    setupVariationButtons($scope);
    setupAddToCartButtons();
    $scope.find('.usk-button.processing').removeClass('processing');
  }

  function GridColumn($scope) {
    initializeGridFunctionality($scope);
  }

  // Cart update handler
  $(document.body).on('added_to_cart removed_from_cart wc_fragments_refreshed', function() {
    setTimeout(function() {
      $('.usk-button.processing').removeClass('processing');

      $('.usk-variations-container').each(function() {
        const $container = $(this);
        const productId = $container.data('product-id');
        const $productItem = $(`.usk-item[data-product-id="${productId}"]`);

        if ($productItem.length) {
          const $addToCartBtn = $productItem.find('.usk-button');
          const selectedAttributes = collectSelectedAttributes($productItem);

          if (Object.keys(selectedAttributes).length > 0) {
            findCorrectVariation($productItem, selectedAttributes, productId).then(correctVariationId => {
              if (correctVariationId) {
                updateButtonAttributes($addToCartBtn, productId, correctVariationId, selectedAttributes);
              }
            });
          }
        }
      });
    }, 500);
  });

  // AJAX content handler
  $(document).ajaxComplete(function (event, xhr) {
    if (xhr.responseText &&
       (xhr.responseText.indexOf("usk-shiny-grid") > -1 ||
        xhr.responseText.indexOf("usk-variation-button") > -1 ||
        xhr.responseText.indexOf("usk-grid") > -1)) {
      initializeGridFunctionality($(document));
    }
  });

  // ===== ELEMENTOR INTEGRATION =====
  $(window).on("elementor/frontend/init", function () {
    // Register widgets
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-shiny-grid.default", GridColumn);
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-glossy-grid.default", setupGridFilter);
    elementorFrontend.hooks.addAction("frontend/element_ready/usk-florence-grid.default", setupGridFilter);
  });
})(jQuery, window.elementorFrontend);

