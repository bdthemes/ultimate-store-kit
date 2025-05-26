/**
 * Ultimate Store Kit - Grid Variations JS
 *
 * Handles the interactive behavior of variation swatches in product grids
 */

(function ($, document) {
  ("use strict");

  var USKGridVariations = function ($container) {
    var self = this;

    self.$container = $container;
    self.productId = $container.data("product-id");
    self.$swatchWrappers = $container.find(".usk-variation-swatches__wrapper");
    self.availableVariations = self.getAvailableVariations();

    // Initial states
    $container.off(".usk-grid-variations");

    // Add a class to the container
    if ($container.find(".usk-variation-swatches__wrapper").length) {
      $container.addClass("swatches-support");
    }

    // Add reset button if not already present
    self.addResetButton();

    // Methods
    self.getChosenAttributes = self.getChosenAttributes.bind(self);

    // Events
    $container.on(
      "click.usk-grid-variations",
      ".usk-variation-swatches__item",
      { USKGridVariations: self },
      self.onSwatchSelect
    );
    $container.on(
      "click.usk-grid-variations",
      ".usk-variation-button",
      { USKGridVariations: self },
      self.onVariationButtonClick
    );
    $container.on(
      "keydown.usk-grid-variations",
      ".usk-variation-swatches__item, .usk-variation-button",
      { USKGridVariations: self },
      self.onKeyPress
    );
    $container.on(
      "click.usk-grid-variations",
      ".usk-reset-variations",
      { USKGridVariations: self },
      self.onResetClick
    );

    $(document.body).trigger("usk_grid_variations_init", self);

    // Initialize active variations
    self.initActiveVariations();

    // Update available attributes based on current selection
    self.updateAvailableAttributes();
  };

  /**
   * Add reset button to the variations container
   */
  USKGridVariations.prototype.addResetButton = function () {
    var self = this;

    // Only add if it doesn't exist already
    if (self.$container.find(".usk-reset-variations").length === 0) {
      var $resetButton = $(
        '<button type="button" class="usk-reset-variations">Reset</button>'
      );
      $resetButton.insertAfter(
        self.$container.find(".usk-variation-group").last()
      );

      // Initially hide the reset button (will show when at least one variation is selected)
      $resetButton.hide();
    }
  };

  /**
   * Handle reset button click
   */
  USKGridVariations.prototype.onResetClick = function (event) {
    event.preventDefault();

    var self = event.data.USKGridVariations;

    // Reset swatches
    self.$container
      .find(".usk-variation-swatches__item")
      .removeClass("selected disabled")
      .data("disabled", false)
      .attr("aria-pressed", "false")
      .attr("tabindex", 0);

    // Reset variation buttons
    self.$container
      .find(".usk-variation-button")
      .removeClass("active disabled")
      .data("disabled", false)
      .attr("tabindex", 0);

    // Reset data attributes
    self.$container.find(".usk-variation-group").each(function () {
      var $group = $(this);
      var attrName = $group
        .find(".usk-variation-button")
        .first()
        .data("attribute");

      if (attrName) {
        self.$container.removeData("selected-attribute_" + attrName);
      }
    });

    self.$swatchWrappers.each(function () {
      var attrName = $(this).data("attribute_name");
      if (attrName) {
        self.$container.removeData("selected-" + attrName);
      }
    });

    // Reset variation ID
    self.$container.removeData("variation-id");

    // Reset Add to Cart button
    var $productItem = self.$container.closest(".usk-item");
    var $addToCartBtn = $productItem.find(".usk-button");

    if ($addToCartBtn.length) {
      $addToCartBtn
        .removeClass(
          "product_type_variation add_to_cart_button ajax_add_to_cart"
        )
        .addClass("product_type_variable")
        .removeAttr("data-variation_id")
        .attr("href", "javascript:void(0)");

      // Remove attribute data
      $addToCartBtn.each(function () {
        var $btn = $(this);
        $.each($btn[0].attributes, function (i, attr) {
          if (attr.name.indexOf("data-attribute_") === 0) {
            $btn.removeAttr(attr.name);
          }
        });
      });

      // Update button text
      var buttonText = $addToCartBtn.find(".usk-icon-arrow-right-8").length
        ? 'Select options <i class="button-icon usk-icon-arrow-right-8"></i>'
        : "Select options";

      $addToCartBtn.html(buttonText);
    }

    // Hide reset button
    self.$container.find(".usk-reset-variations").hide();

    // Update available attributes
    self.updateAvailableAttributes();
  };

  /**
   * Get available variations from data attribute if available
   */
  USKGridVariations.prototype.getAvailableVariations = function () {
    var self = this;
    var variations = self.$container.data("available_variations");

    if (!variations && typeof usk_vars !== "undefined" && usk_vars.ajax_url) {
      // If variations aren't stored in data, try to fetch them via AJAX
      $.ajax({
        url: usk_vars.ajax_url,
        type: "POST",
        async: false,
        data: {
          action: "usk_get_available_variations",
          product_id: self.productId,
        },
        success: function (response) {
          if (response.success && response.data) {
            variations = response.data;
            // Store for future use
            self.$container.data("available_variations", variations);
          }
        },
      });
    }

    return variations || [];
  };

  /**
   * Initialize active variation items
   */
  USKGridVariations.prototype.initActiveVariations = function () {
    var self = this;
    var selectedCount = 0;

    // Trigger click on selected swatches
    self.$container
      .find(".usk-variation-swatches__item.selected")
      .each(function () {
        $(this).trigger("click.usk-grid-variations");
        selectedCount++;
      });

    // Trigger click on active variation buttons
    self.$container.find(".usk-variation-button.active").each(function () {
      $(this).trigger("click.usk-grid-variations");
      selectedCount++;
    });

    // If no variations are already selected, select any default attributes
    if (selectedCount === 0) {
      var defaultAttributes = self.$container.data("default_attributes");
      if (defaultAttributes) {
        // Try to select default attributes
        for (var attrName in defaultAttributes) {
          if (defaultAttributes.hasOwnProperty(attrName)) {
            var value = defaultAttributes[attrName];
            var $item = self.$container.find(
              '.usk-variation-swatches__item[data-value="' + value + '"]'
            );

            if ($item.length) {
              $item.trigger("click.usk-grid-variations");
            } else {
              // Try button format
              var $button = self.$container.find(
                '.usk-variation-button[data-value="' + value + '"]'
              );
              if ($button.length) {
                $button.trigger("click.usk-grid-variations");
              }
            }
          }
        }
      }
    }

    // Show/hide reset button based on selections
    self.toggleResetButton();

    // If no items are selected, just update all available attributes
    if (selectedCount === 0) {
      self.updateAvailableAttributes();
    }
  };

  /**
   * Toggle reset button visibility based on selections
   */
  USKGridVariations.prototype.toggleResetButton = function () {
    var self = this;
    var attributes = self.getChosenAttributes();
    var $resetButton = self.$container.find(".usk-reset-variations");

    if (attributes.chosenCount > 0) {
      $resetButton.show();
    } else {
      $resetButton.hide();
    }
  };

  /**
   * Handle click on a swatch
   */
  USKGridVariations.prototype.onSwatchSelect = function (event) {
    event.preventDefault();

    var self = event.data.USKGridVariations;
    var $swatch = $(this);

    if ($swatch.hasClass("disabled") || $swatch.data("disabled")) {
      return;
    }

    var $wrapper = $swatch.closest(".usk-variation-swatches__wrapper");
    var attributeName = $wrapper.data("attribute_name");
    var value = $swatch.data("value");

    // Update selected state visually
    $wrapper
      .find(".usk-variation-swatches__item")
      .removeClass("selected")
      .attr("aria-pressed", "false");
    $swatch.addClass("selected").attr("aria-pressed", "true");

    // Store selected attribute in data
    self.$container.data("selected-" + attributeName, value);

    // Update available attributes based on this selection
    self.updateAvailableAttributes();

    // Show/hide reset button
    self.toggleResetButton();

    // Update Add to Cart button
    self.updateAddToCartButton();
  };

  /**
   * Handle click on variation button
   */
  USKGridVariations.prototype.onVariationButtonClick = function (event) {
    event.preventDefault();

    var self = event.data.USKGridVariations;
    var $button = $(this);
    var attribute = $button.data("attribute");
    var value = $button.data("value");

    if ($button.hasClass("disabled") || $button.data("disabled")) {
      return;
    }

    // Update active state
    $button.siblings(".usk-variation-button").removeClass("active");
    $button.addClass("active");

    // Store selected attribute in data
    self.$container.data("selected-" + attribute, value);

    // Update available attributes based on this selection
    self.updateAvailableAttributes();

    // Show/hide reset button
    self.toggleResetButton();

    // Update Add to Cart button
    self.updateAddToCartButton();
  };

  /**
   * Update available attributes based on current selection
   * Disables attributes that are not available with current selection
   */
  USKGridVariations.prototype.updateAvailableAttributes = function () {
    var self = this;
    var attributes = self.getChosenAttributes();
    var currentAttributes = attributes.data;
    var variations = self.availableVariations;

    // If we don't have variations data, we can't determine availability
    if (!variations || !variations.length) {
      return;
    }

    // First, reset all attributes to enabled state
    self.$container
      .find(".usk-variation-swatches__item")
      .removeClass("disabled")
      .data("disabled", false)
      .attr("tabindex", 0);
    self.$container
      .find(".usk-variation-button")
      .removeClass("disabled")
      .data("disabled", false)
      .attr("tabindex", 0);

    // If no attributes are chosen, nothing to disable
    if (!attributes.chosenCount) {
      return;
    }

    // For each attribute wrapper, find and disable unavailable options
    self.$swatchWrappers.each(function () {
      var $attributeWrapper = $(this);
      var attributeName = $attributeWrapper.data("attribute_name");
      var $items = $attributeWrapper.find(".usk-variation-swatches__item");

      $items.each(function () {
        var $item = $(this);
        var attributeValue = $item.data("value");

        // Check if this value is available with the current selections
        var isAvailable = self.isAttributeAvailable(
          attributeName,
          attributeValue,
          currentAttributes
        );

        if (!isAvailable) {
          $item
            .addClass("disabled")
            .data("disabled", true)
            .attr("tabindex", -1);
        }
      });
    });

    // Also handle regular variation buttons
    self.$container.find(".usk-variation-group").each(function () {
      var $group = $(this);
      var attributeName =
        "attribute_" +
        $group.find(".usk-variation-button").first().data("attribute");
      var $buttons = $group.find(".usk-variation-button");

      $buttons.each(function () {
        var $button = $(this);
        var attributeValue = $button.data("value");

        // Check if this value is available with the current selections
        var isAvailable = self.isAttributeAvailable(
          attributeName,
          attributeValue,
          currentAttributes
        );

        if (!isAvailable) {
          $button
            .addClass("disabled")
            .data("disabled", true)
            .attr("tabindex", -1);
        }
      });
    });
  };

  /**
   * Check if a specific attribute value is available based on current selections
   */
  USKGridVariations.prototype.isAttributeAvailable = function (
    attributeName,
    attributeValue,
    currentAttributes
  ) {
    var self = this;
    var variations = self.availableVariations;

    if (!variations || !variations.length) {
      return true; // If we don't have variations data, assume everything is available
    }

    // Create a copy of current attributes to test with
    var testAttributes = {};
    for (var key in currentAttributes) {
      if (
        currentAttributes.hasOwnProperty(key) &&
        currentAttributes[key] !== ""
      ) {
        testAttributes[key] = currentAttributes[key];
      }
    }

    // Set the attribute we're testing
    testAttributes[attributeName] = attributeValue;

    // Check if any variations match the test attributes
    for (var i = 0; i < variations.length; i++) {
      var variation = variations[i];
      var attributes = variation.attributes;
      var match = true;

      // Check if this variation matches all our test attributes
      for (var testKey in testAttributes) {
        if (testAttributes.hasOwnProperty(testKey)) {
          var testValue = testAttributes[testKey];

          // Skip if variation doesn't define this attribute
          if (typeof attributes[testKey] === "undefined") {
            continue;
          }

          // If variation attribute is empty, it matches any value
          if (attributes[testKey] === "") {
            continue;
          }

          // Actual value check
          if (attributes[testKey] !== testValue) {
            match = false;
            break;
          }
        }
      }

      // We found a matching variation, so this attribute value is available
      if (match && variation.is_in_stock && variation.is_purchasable) {
        return true;
      }
    }

    return false;
  };

  /**
   * Handle keypress events for accessibility
   */
  USKGridVariations.prototype.onKeyPress = function (event) {
    if (
      (event.keyCode && 32 === event.keyCode) ||
      (event.key && " " === event.key) ||
      (event.keyCode && 13 === event.keyCode) ||
      (event.key && "enter" === event.key.toLowerCase())
    ) {
      event.preventDefault();
      $(this).trigger("click.usk-grid-variations");
    }
  };

  /**
   * Update product image with the provided URL
   */
  USKGridVariations.prototype.updateProductImage = function (imageUrl) {
    var self = this;
    var $productItem = self.$container.closest(".usk-item");

    // Update both default and hover image
    $productItem
      .find(".usk-image .img.image-default, .usk-image .img.image-hover")
      .attr("src", imageUrl);
  };

  /**
   * Update Add to Cart button based on selected variations
   */
  USKGridVariations.prototype.updateAddToCartButton = function () {
    var self = this;
    var $productItem = self.$container.closest(".usk-item");
    var $addToCartBtn = $productItem.find(".usk-button");

    if (!$addToCartBtn.length) {
      return;
    }

    // Check if all attributes are selected
    var attributes = self.getChosenAttributes();
    if (attributes.chosenCount !== attributes.count) {
      // Not all attributes selected, reset button to Select Options
      $addToCartBtn
        .removeClass(
          "product_type_variation add_to_cart_button ajax_add_to_cart"
        )
        .addClass("product_type_variable")
        .removeAttr("data-variation_id")
        .attr("href", "javascript:void(0)");

      // Clear any attribute data
      $.each($addToCartBtn[0].attributes, function (i, attr) {
        if (attr.name && attr.name.indexOf("data-attribute_") === 0) {
          $addToCartBtn.removeAttr(attr.name);
        }
      });

      // Update button text to Select Options
      var buttonText = $addToCartBtn.find(".usk-icon-arrow-right-8").length
        ? 'Select options <i class="button-icon usk-icon-arrow-right-8"></i>'
        : "Select options";

      $addToCartBtn.html(buttonText);
      return;
    }

    // Find the matching variation based on selected attributes
    self.findMatchingVariation(attributes.data, function (variationId) {
      // Store variation ID in container data
      self.$container.data("variation-id", variationId);

      if (!variationId) {
        // No matching variation found
        $addToCartBtn
          .removeClass(
            "product_type_variation add_to_cart_button ajax_add_to_cart"
          )
          .addClass("product_type_variable")
          .removeAttr("data-variation_id")
          .attr("href", "javascript:void(0)");

        // Update button text to Unavailable
        var buttonText = $addToCartBtn.find(".usk-icon-arrow-right-8").length
          ? 'Unavailable <i class="button-icon usk-icon-arrow-right-8"></i>'
          : "Unavailable";

        $addToCartBtn.html(buttonText);
        return;
      }

      // Clear existing attribute data
      $.each($addToCartBtn[0].attributes, function (i, attr) {
        if (attr.name && attr.name.indexOf("data-attribute_") === 0) {
          $addToCartBtn.removeAttr(attr.name);
        }
      });

      // Make button an Add to Cart button
      $addToCartBtn
        .removeClass("product_type_variable")
        .addClass("product_type_variation add_to_cart_button ajax_add_to_cart")
        .attr("data-product_id", self.productId)
        .attr("data-variation_id", variationId)
        .attr("data-prevent_redirect", "true")
        .attr("href", "javascript:void(0)");

      // Add attribute data
      $.each(attributes.data, function (name, value) {
        if (value) {
          $addToCartBtn.attr("data-" + name, value);
        }
      });

      // Update button text
      var buttonText = $addToCartBtn.find(".usk-icon-arrow-right-8").length
        ? 'Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>'
        : "Add to cart";

      $addToCartBtn.html(buttonText);
    });
  };

  /**
   * Find matching variation ID for the given attributes
   * Uses AJAX to query the server if not found locally
   */
  USKGridVariations.prototype.findMatchingVariation = function (
    attributesData,
    callback
  ) {
    var self = this;
    var variations = self.availableVariations;
    var matchingVariationId = null;

    // Try to find matching variation locally first
    if (variations && variations.length) {
      for (var i = 0; i < variations.length; i++) {
        var variation = variations[i];
        var attributes = variation.attributes;
        var match = true;

        // Check if this variation matches all selected attributes
        for (var attrName in attributesData) {
          if (
            attributesData.hasOwnProperty(attrName) &&
            attributesData[attrName] !== ""
          ) {
            var attrValue = attributesData[attrName];

            // Skip if variation doesn't define this attribute
            if (typeof attributes[attrName] === "undefined") {
              continue;
            }

            // If variation attribute is empty, it matches any value
            if (attributes[attrName] === "") {
              continue;
            }

            // Actual value check
            if (attributes[attrName] !== attrValue) {
              match = false;
              break;
            }
          }
        }

        // Found a matching variation
        if (match && variation.is_in_stock && variation.is_purchasable) {
          matchingVariationId = variation.variation_id;
          break;
        }
      }
    }

    // If we found a matching variation locally, return it immediately
    if (matchingVariationId) {
      callback(matchingVariationId);
      return;
    }

    // If not found locally and AJAX is available, try to find it on the server
    if (typeof usk_vars !== "undefined" && usk_vars.ajax_url) {
      // Format attributes for the AJAX request
      var formattedAttributes = {};
      for (var key in attributesData) {
        if (attributesData.hasOwnProperty(key)) {
          var attrName = key.replace("attribute_", "");
          formattedAttributes[attrName] = attributesData[key];
        }
      }

      $.ajax({
        url: usk_vars.ajax_url,
        type: "POST",
        data: {
          action: "usk_find_variation",
          product_id: self.productId,
          attributes: formattedAttributes,
          security: usk_vars.nonce || "",
        },
        success: function (response) {
          if (response.success && response.data && response.data.variation_id) {
            callback(response.data.variation_id);
          } else {
            callback(null);
          }
        },
        error: function () {
          callback(null);
        },
      });
    } else {
      callback(null);
    }
  };

  /**
   * Get chosen attributes from container
   */
  USKGridVariations.prototype.getChosenAttributes = function () {
    var self = this;
    var data = {};
    var count = 0;
    var chosen = 0;

    // Get attributes from variation swatches
    self.$swatchWrappers.each(function () {
      var attribute_name = $(this).data("attribute_name");
      var $selected = $(this).find(".usk-variation-swatches__item.selected");
      var value = $selected.length ? $selected.data("value") : "";

      if (value.length > 0) {
        chosen++;
      }

      count++;
      data[attribute_name] = value;
    });

    // Also get attributes from variation buttons
    self.$container.find(".usk-variation-group").each(function () {
      var $group = $(this);
      var $activeBtn = $group.find(".usk-variation-button.active");

      if ($activeBtn.length) {
        var attribute = "attribute_" + $activeBtn.data("attribute");
        var value = $activeBtn.data("value");

        if (!data[attribute]) {
          if (value.length > 0) {
            chosen++;
          }

          count++;
          data[attribute] = value;
        }
      }
    });

    return {
      count: count,
      chosenCount: chosen,
      data: data,
    };
  };

  /**
   * Function to call USKGridVariations on jquery selector
   */
  $.fn.usk_grid_variations = function () {
    return this.each(function () {
      new USKGridVariations($(this));
    });
  };

  /**
   * Initialize grid variations on all containers
   */
  function init_grid_variations() {
    $(".usk-variations-container:not(.swatches-support)").each(function () {
      $(this).usk_grid_variations();
    });
  }

  $(function () {
    // Initialize on page load
    init_grid_variations();
    // Also reinitialize after cart fragments refresh (important for when returning from cart/checkout)
    $(document.body).on(
      "wc_fragments_refreshed wc_fragments_loaded added_to_cart",
      function () {
        init_grid_variations();
      }
    );
  });
})(jQuery, document);

