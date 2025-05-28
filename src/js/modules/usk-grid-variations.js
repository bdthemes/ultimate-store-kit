/**
 * Ultimate Store Kit - Grid Variations JS
 *
 * Handles the interactive behavior of variation swatches in product grids
 */

class USKGridVariations {
  constructor($container) {
    this.$container = $container;
    this.productId = $container.data("product-id");
    this.$swatchWrappers = $container.find(".usk-variation-swatches__wrapper");
    this.availableVariations = this.getAvailableVariations();
    this.sequentialMode = $container.data("sequential") === true;
    this.currentStep = 0;
    this.totalSteps = 0;

    // Initialize the container
    this.initContainer();

    // Bind methods to maintain context
    this.bindMethods();

    // Set up event handlers
    this.setupEventListeners();

    // Initialize variations
    this.initActiveVariations();

    // Initialize available attributes immediately to disable unavailable options
    this.updateAvailableAttributes(true); // Passing true to indicate initial load

    // Setup sequential mode if enabled
    if (this.sequentialMode) {
      this.setupSequentialMode();
    }

    // Trigger initialization event
    jQuery(document.body).trigger("usk_grid_variations_init", this);
  }

  // Initialize container with required elements
  initContainer() {
    this.$container.off(".usk-grid-variations");

    // Add classes
    if (this.$swatchWrappers.length) {
      this.$container.addClass("swatches-support");
    }

    if (this.sequentialMode) {
      this.$container.addClass("usk-sequential-variations");
    }

    // Add required buttons
    this.addResetButton();

    if (this.sequentialMode) {
      this.addBackButton();
    }
  }

  // Bind methods to maintain 'this' context
  bindMethods() {
    this.getChosenAttributes = this.getChosenAttributes.bind(this);
    this.onSwatchSelect = this.onSwatchSelect.bind(this);
    this.onVariationButtonClick = this.onVariationButtonClick.bind(this);
    this.onKeyPress = this.onKeyPress.bind(this);
    this.onResetClick = this.onResetClick.bind(this);
    this.onBackClick = this.onBackClick.bind(this);
  }

  // Set up event listeners
  setupEventListeners() {
    this.$container.on(
      "click.usk-grid-variations",
      ".usk-variation-swatches__item",
      this.onSwatchSelect
    );

    this.$container.on(
      "click.usk-grid-variations",
      ".usk-variation-button",
      this.onVariationButtonClick
    );

    this.$container.on(
      "keydown.usk-grid-variations",
      ".usk-variation-swatches__item, .usk-variation-button",
      this.onKeyPress
    );

    this.$container.on(
      "click.usk-grid-variations",
      ".usk-reset-variations",
      this.onResetClick
    );

    this.$container.on(
      "click.usk-grid-variations",
      ".usk-back-variation",
      this.onBackClick
    );
  }

  // Add reset button to the variations container
  addResetButton() {
    if (this.$container.find(".usk-reset-variations").length === 0) {
      const $resetButton =
        jQuery(`<button type="button" class="usk-reset-variations" aria-label="Reset">
    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path
        stroke="currentColor"
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"
      />
    </svg>
  </button>
`);
      $resetButton.insertAfter(
        this.$container.find(".usk-variation-group").last()
      );
      $resetButton.hide();
    }
  }

  // Add back button for sequential variation selection
  addBackButton() {
    if (this.$container.find(".usk-back-variation").length === 0) {
      const $backButton = jQuery(`
  <button type="button" class="usk-back-variation" aria-label="Go Back">
    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
</svg>
  </button>
`);

      $backButton.insertAfter(
        this.$container.find(".usk-variation-group").first()
      );
      $backButton.hide();
    }
  }

  // Setup sequential variation selection mode
  setupSequentialMode() {
    this.totalSteps =
      this.$container.find(".usk-variation-group").length ||
      this.$swatchWrappers.length;

    if (this.totalSteps > 1) {
      this.$container.find(".usk-variation-group").each((index, el) => {
        jQuery(el).toggle(index === 0);
      });

      this.$swatchWrappers.each((index, el) => {
        jQuery(el).toggle(index === 0);
      });
    }

    this.currentStep = 0;
  }

  // Go to the next variation step
  goToNextStep() {
    if (this.currentStep < this.totalSteps - 1) {
      this.currentStep++;

      this.$container.find(".usk-variation-group").each((index, el) => {
        jQuery(el).toggle(index === this.currentStep);
      });

      this.$swatchWrappers.each((index, el) => {
        jQuery(el).toggle(index === this.currentStep);
      });

      if (this.currentStep > 0) {
        this.$container.find(".usk-back-variation").show();
      }
    }
  }

  // Go to the previous variation step
  goToPreviousStep() {
    if (this.currentStep > 0) {
      this.currentStep--;

      this.$container.find(".usk-variation-group").each((index, el) => {
        jQuery(el).toggle(index === this.currentStep);
      });

      this.$swatchWrappers.each((index, el) => {
        jQuery(el).toggle(index === this.currentStep);
      });

      if (this.currentStep === 0) {
        this.$container.find(".usk-back-variation").hide();
      }
    }
  }

  // Handle back button click
  onBackClick(event) {
    event.preventDefault();
    this.goToPreviousStep();
  }

  // Handle reset button click
  onResetClick(event) {
    event.preventDefault();

    // Reset swatches and buttons
    this.$container
      .find(".usk-variation-swatches__item, .usk-variation-button")
      .removeClass("selected active disabled")
      .data("disabled", false)
      .attr("aria-pressed", "false")
      .attr("tabindex", 0);

    // Reset data attributes
    this.resetDataAttributes();

    // Reset Add to Cart button
    this.resetAddToCartButton();

    // Reset UI elements
    this.$container.find(".usk-reset-variations").hide();
    this.removeVariationSummary();
    this.$container.find(".usk-step-summary").remove();

    // Reset sequential mode if enabled
    if (this.sequentialMode) {
      this.resetSequentialMode();
    }

    // Update available attributes
    this.updateAvailableAttributes(true);
  }

  // Reset all data attributes
  resetDataAttributes() {
    // Reset variation group data
    this.$container.find(".usk-variation-group").each((i, el) => {
      const $group = jQuery(el);
      const $button = $group.find(".usk-variation-button").first();

      if ($button.length) {
        const attrName = $button.data("attribute");
        if (attrName) {
          this.$container.removeData("selected-attribute_" + attrName);
        }
      }
    });

    // Reset swatch wrapper data
    this.$swatchWrappers.each((i, el) => {
      const attrName = jQuery(el).data("attribute_name");
      if (attrName) {
        this.$container.removeData("selected-" + attrName);
      }
    });

    // Reset variation ID
    this.$container.removeData("variation-id");
  }

  // Reset Add to Cart button to default state
  resetAddToCartButton() {
    const $productItem = this.$container.closest(".usk-item");
    const $addToCartBtn = $productItem.find(".usk-button");

    if (!$addToCartBtn.length) return;

    $addToCartBtn
      .removeClass("product_type_variation add_to_cart_button ajax_add_to_cart")
      .addClass("product_type_variable")
      .removeAttr("data-variation_id")
      .attr("href", "javascript:void(0)");

    // Remove attribute data
    try {
      jQuery.each($addToCartBtn[0].attributes, (i, attr) => {
        if (attr && attr.name && attr.name.indexOf("data-attribute_") === 0) {
          $addToCartBtn.removeAttr(attr.name);
        }
      });
    } catch (e) {
      console.log("Error clearing button attributes:", e);
    }

    // Update button text
    const buttonText = $addToCartBtn.find(".usk-icon-arrow-right-8").length
      ? 'Select options <i class="button-icon usk-icon-arrow-right-8"></i>'
      : "Select options";

    $addToCartBtn.html(buttonText);
  }

  // Reset sequential mode to first step
  resetSequentialMode() {
    this.$container.find(".usk-back-variation").hide();
    this.currentStep = 0;

    this.$container.find(".usk-variation-group").each((index, el) => {
      jQuery(el).toggle(index === 0);
    });

    this.$swatchWrappers.each((index, el) => {
      jQuery(el).toggle(index === 0);
    });
  }

  // Get available variations from data attribute or AJAX
  getAvailableVariations() {
    let variations = this.$container.data("available_variations");

    if (!variations && typeof usk_vars !== "undefined" && usk_vars.ajax_url) {
      jQuery.ajax({
        url: usk_vars.ajax_url,
        type: "POST",
        async: false,
        data: {
          action: "usk_get_available_variations",
          product_id: this.productId,
        },
        success: (response) => {
          if (response.success && response.data) {
            variations = response.data;
            this.$container.data("available_variations", variations);
          }
        },
      });
    }

    return variations || [];
  }

  // Initialize active variation items
  initActiveVariations() {
    let selectedCount = 0;

    // Activate pre-selected swatches
    this.$container
      .find(".usk-variation-swatches__item.selected")
      .each((i, el) => {
        jQuery(el).trigger("click.usk-grid-variations");
        selectedCount++;
      });

    // Activate pre-selected buttons
    this.$container.find(".usk-variation-button.active").each((i, el) => {
      jQuery(el).trigger("click.usk-grid-variations");
      selectedCount++;
    });

    // Select default attributes if nothing is selected
    if (selectedCount === 0) {
      this.selectDefaultAttributes();
    }

    // Toggle reset button
    this.toggleResetButton();
  }

  // Select default attributes if provided
  selectDefaultAttributes() {
    const defaultAttributes = this.$container.data("default_attributes");
    if (!defaultAttributes) return;

    for (const attrName in defaultAttributes) {
      if (defaultAttributes.hasOwnProperty(attrName)) {
        const value = defaultAttributes[attrName];

        // Try to find and select matching swatch
        const $item = this.$container.find(
          `.usk-variation-swatches__item[data-value="${value}"]`
        );

        if ($item.length) {
          $item.trigger("click.usk-grid-variations");
        } else {
          // Try to find and select matching button
          const $button = this.$container.find(
            `.usk-variation-button[data-value="${value}"]`
          );

          if ($button.length) {
            $button.trigger("click.usk-grid-variations");
          }
        }
      }
    }
  }

  // Toggle reset button visibility based on selections
  toggleResetButton() {
    const attributes = this.getChosenAttributes();
    const $resetButton = this.$container.find(".usk-reset-variations");

    $resetButton.toggle(attributes.chosenCount > 0);
  }

  // Handle click on a swatch
  onSwatchSelect(event) {
    event.preventDefault();

    const $swatch = jQuery(event.currentTarget);

    if ($swatch.hasClass("disabled") || $swatch.data("disabled")) {
      return;
    }

    const $wrapper = $swatch.closest(".usk-variation-swatches__wrapper");
    const attributeName = $wrapper.data("attribute_name");
    const value = $swatch.data("value");

    // Update UI
    $wrapper
      .find(".usk-variation-swatches__item")
      .removeClass("selected")
      .attr("aria-pressed", "false");

    $swatch.addClass("selected").attr("aria-pressed", "true");

    // Store selection
    this.$container.data("selected-" + attributeName, value);

    // Update state
    this.updateAvailableAttributes();
    this.toggleResetButton();
    this.updateAddToCartButton();

    // Handle sequential mode
    if (this.sequentialMode && this.currentStep < this.totalSteps - 1) {
      this.goToNextStep();
    }
  }

  // Handle click on variation button
  onVariationButtonClick(event) {
    event.preventDefault();

    const $button = jQuery(event.currentTarget);
    const attribute = $button.data("attribute");
    const value = $button.data("value");

    if ($button.hasClass("disabled") || $button.data("disabled")) {
      return;
    }

    // Update UI
    $button.siblings(".usk-variation-button").removeClass("active");
    $button.addClass("active");

    // Store selection
    this.$container.data("selected-attribute_" + attribute, value);

    // Update state
    this.updateAvailableAttributes();
    this.toggleResetButton();
    this.updateAddToCartButton();

    // Handle sequential mode
    if (this.sequentialMode && this.currentStep < this.totalSteps - 1) {
      this.goToNextStep();
    }
  }

  // Update available attributes based on current selection
  updateAvailableAttributes(isInitialLoad = false) {
    const attributes = this.getChosenAttributes();
    const currentAttributes = attributes.data;
    const variations = this.availableVariations;

    // If no variations data, we can't determine availability
    if (!variations || !variations.length) {
      return;
    }

    // Reset all to enabled state
    this.$container
      .find(".usk-variation-swatches__item, .usk-variation-button")
      .removeClass("disabled")
      .data("disabled", false)
      .attr("tabindex", 0);

    // First pass: Mark all options that don't have any valid variations as disabled
    // This should happen even if no attributes are chosen yet (on initial load)
    if (isInitialLoad || !attributes.chosenCount) {
      // Process swatch wrappers - mark all unavailable attributes as disabled immediately
      this.$swatchWrappers.each((i, wrapper) => {
        const $wrapper = jQuery(wrapper);
        const attributeName = $wrapper.data("attribute_name");

        $wrapper.find(".usk-variation-swatches__item").each((j, item) => {
          const $item = jQuery(item);
          const attributeValue = $item.data("value");

          // Check if this value appears in any variation
          let isAvailable = false;
          for (let v = 0; v < variations.length; v++) {
            const variation = variations[v];

            if (!variation || !variation.attributes ||
                !variation.is_in_stock || !variation.is_purchasable) {
              continue;
            }

            const variationAttrs = variation.attributes;

            // Check if this variation includes this attribute value
            if (variationAttrs[attributeName] === "" ||
                variationAttrs[attributeName] === attributeValue) {
              isAvailable = true;
              break;
            }
          }

          // Disable if not available in any variation
          if (!isAvailable) {
            $item
              .addClass("disabled")
              .data("disabled", true)
              .attr("tabindex", -1);
          }
        });
      });

      // Process variation buttons - mark all unavailable buttons as disabled immediately
      this.$container.find(".usk-variation-group").each((i, group) => {
        const $group = jQuery(group);
        const firstButton = $group.find(".usk-variation-button").first();
        const attributeName = "attribute_" + firstButton.data("attribute");

        $group.find(".usk-variation-button").each((j, button) => {
          const $button = jQuery(button);
          const attributeValue = $button.data("value");

          // Check if this value appears in any variation
          let isAvailable = false;
          for (let v = 0; v < variations.length; v++) {
            const variation = variations[v];

            if (!variation || !variation.attributes ||
                !variation.is_in_stock || !variation.is_purchasable) {
              continue;
            }

            const variationAttrs = variation.attributes;

            // Check if this variation includes this attribute value
            if (variationAttrs[attributeName] === "" ||
                variationAttrs[attributeName] === attributeValue) {
              isAvailable = true;
              break;
            }
          }

          // Disable if not available in any variation
          if (!isAvailable) {
            $button
              .addClass("disabled")
              .data("disabled", true)
              .attr("tabindex", -1);
          }
        });
      });

      return;
    }

    // Second pass: If attributes are chosen, show only compatible options
    // Process swatch wrappers
    this.$swatchWrappers.each((i, wrapper) => {
      const $wrapper = jQuery(wrapper);
      const attributeName = $wrapper.data("attribute_name");

      $wrapper.find(".usk-variation-swatches__item").each((j, item) => {
        const $item = jQuery(item);
        const attributeValue = $item.data("value");

        // Disable if not available with current selections
        if (
          !this.isAttributeAvailable(
            attributeName,
            attributeValue,
            currentAttributes
          )
        ) {
          $item
            .addClass("disabled")
            .data("disabled", true)
            .attr("tabindex", -1);
        }
      });
    });

    // Process variation buttons
    this.$container.find(".usk-variation-group").each((i, group) => {
      const $group = jQuery(group);
      const firstButton = $group.find(".usk-variation-button").first();
      const attributeName = "attribute_" + firstButton.data("attribute");

      $group.find(".usk-variation-button").each((j, button) => {
        const $button = jQuery(button);
        const attributeValue = $button.data("value");

        // Disable if not available with current selections
        if (
          !this.isAttributeAvailable(
            attributeName,
            attributeValue,
            currentAttributes
          )
        ) {
          $button
            .addClass("disabled")
            .data("disabled", true)
            .attr("tabindex", -1);
        }
      });
    });
  }

  // Check if a specific attribute value is available based on current selections
  isAttributeAvailable(attributeName, attributeValue, currentAttributes) {
    const variations = this.availableVariations;

    // Basic validation
    if (!attributeName || !attributeValue || !currentAttributes) {
      return true;
    }

    if (!variations || !variations.length) {
      return true;
    }

    // Create test attributes object
    const testAttributes = {};
    for (const key in currentAttributes) {
      if (
        currentAttributes.hasOwnProperty(key) &&
        currentAttributes[key] !== ""
      ) {
        testAttributes[key] = currentAttributes[key];
      }
    }

    // Add the attribute we're testing
    testAttributes[attributeName] = attributeValue;

    // Check for matching variations
    for (let i = 0; i < variations.length; i++) {
      const variation = variations[i];

      if (!variation || !variation.attributes) {
        continue;
      }

      const attributes = variation.attributes;
      let match = true;

      // Check if this variation matches test attributes
      for (const testKey in testAttributes) {
        if (testAttributes.hasOwnProperty(testKey)) {
          const testValue = testAttributes[testKey];

          // Skip if variation doesn't define this attribute
          if (typeof attributes[testKey] === "undefined") {
            continue;
          }

          // If variation attribute is empty, it matches any value
          if (attributes[testKey] === "") {
            continue;
          }

          // Check for exact match
          if (attributes[testKey] !== testValue) {
            match = false;
            break;
          }
        }
      }

      // Return true if we found a matching variation
      if (match && variation.is_in_stock && variation.is_purchasable) {
        return true;
      }
    }

    return false;
  }

  // Handle keypress events for accessibility
  onKeyPress(event) {
    const isSpace =
      (event.keyCode && event.keyCode === 32) ||
      (event.key && event.key === " ");
    const isEnter =
      (event.keyCode && event.keyCode === 13) ||
      (event.key && event.key.toLowerCase() === "enter");

    if (isSpace || isEnter) {
      event.preventDefault();
      jQuery(event.currentTarget).trigger("click.usk-grid-variations");
    }
  }

  // Update product image with the provided URL
  updateProductImage(imageUrl) {
    if (!imageUrl) return;

    const $productItem = this.$container.closest(".usk-item");
    const $defaultImage = $productItem.find(".usk-image .img.image-default");
    const $hoverImage = $productItem.find(".usk-image .img.image-hover");

    // Update images with new src
    if ($defaultImage.length) {
      $defaultImage.attr("src", imageUrl);
    }

    if ($hoverImage.length) {
      $hoverImage.attr("src", imageUrl);
    }

    // Also update srcset if it exists
    if ($defaultImage.attr("srcset")) {
      $defaultImage.attr("srcset", "");
    }

    if ($hoverImage.attr("srcset")) {
      $hoverImage.attr("srcset", "");
    }
  }

  // Update Add to Cart button based on selected variations
  updateAddToCartButton() {
    const $productItem = this.$container.closest(".usk-item");
    const $addToCartBtn = $productItem.find(".usk-button");

    if (!$addToCartBtn.length) {
      return;
    }

    // Check if all attributes are selected
    const attributes = this.getChosenAttributes();
    if (!attributes || attributes.chosenCount !== attributes.count) {
      this.resetAddToCartToSelectOptions($addToCartBtn);
      return;
    }

    // Make sure we have all required variations selected
    const requiredAttributeCount = this.getTotalRequiredAttributes();
    if (attributes.chosenCount < requiredAttributeCount) {
      this.resetAddToCartToSelectOptions($addToCartBtn);
      return;
    }

    // Find matching variation
    this.findMatchingVariation(
      attributes.data,
      (variationId, variationData) => {
        // Store variation ID
        this.$container.data("variation-id", variationId);

        if (!variationId) {
          this.setUnavailableButton($addToCartBtn);
          return;
        }

        // Update the product image if variation has an image
        if (variationData && variationData.image && variationData.image.src) {
          this.updateProductImage(variationData.image.src);
        }

        this.setAddToCartButton($addToCartBtn, variationId, attributes);
      }
    );
  }

  // Reset button to "Select Options" state
  resetAddToCartToSelectOptions($button) {
    $button
      .removeClass("product_type_variation add_to_cart_button ajax_add_to_cart")
      .addClass("product_type_variable")
      .removeAttr("data-variation_id")
      .attr("href", "javascript:void(0)");

    // Clear attributes
    this.clearButtonAttributes($button);

    // Update text
    const buttonText = $button.find(".usk-icon-arrow-right-8").length
      ? 'Select options <i class="button-icon usk-icon-arrow-right-8"></i>'
      : "Select options";

    $button.html(buttonText);

    // Remove any summary
    this.removeVariationSummary();
  }

  // Set button to "Unavailable" state
  setUnavailableButton($button) {
    $button
      .removeClass("product_type_variation add_to_cart_button ajax_add_to_cart")
      .addClass("product_type_variable")
      .removeAttr("data-variation_id")
      .attr("href", "javascript:void(0)");

    // Update text
    const buttonText = $button.find(".usk-icon-arrow-right-8").length
      ? 'Unavailable <i class="button-icon usk-icon-arrow-right-8"></i>'
      : "Unavailable";

    $button.html(buttonText);

    // Remove any summary
    this.removeVariationSummary();
  }

  // Set button to "Add to Cart" state with variation data
  setAddToCartButton($button, variationId, attributes) {
    // Clear existing attributes
    this.clearButtonAttributes($button);

    // Set button properties
    $button
      .removeClass("product_type_variable")
      .addClass("product_type_variation add_to_cart_button ajax_add_to_cart")
      .attr("data-product_id", this.productId)
      .attr("data-variation_id", variationId)
      .attr("data-prevent_redirect", "true")
      .attr("href", "javascript:void(0)");

    // Add attribute data
    if (attributes.data) {
      jQuery.each(attributes.data, (name, value) => {
        if (name && value) {
          $button.attr("data-" + name, value);
        }
      });
    }

    // Update text
    const buttonText = $button.find(".usk-icon-arrow-right-8").length
      ? 'Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>'
      : "Add to cart";

    $button.html(buttonText);
  }

  // Clear data-attribute_ properties from button
  clearButtonAttributes($button) {
    try {
      jQuery.each($button[0].attributes, (i, attr) => {
        if (attr && attr.name && attr.name.indexOf("data-attribute_") === 0) {
          $button.removeAttr(attr.name);
        }
      });
    } catch (e) {
      console.log("Error clearing attributes:", e);
    }
  }

  // Remove the variation summary display
  removeVariationSummary() {
    this.$container.find(".usk-variation-summary").remove();
  }

  // Find matching variation ID for the given attributes
  findMatchingVariation(attributesData, callback) {
    if (!attributesData) {
      callback(null);
      return;
    }

    // Try to find match locally first
    const matchingVariation = this.findMatchingVariationLocally(attributesData);

    if (matchingVariation) {
      callback(matchingVariation.variation_id, matchingVariation);
      return;
    }

    // If not found locally, try server
    this.findMatchingVariationOnServer(attributesData, callback);
  }

  // Find matching variation locally
  findMatchingVariationLocally(attributesData) {
    const variations = this.availableVariations;

    if (!variations || !variations.length) {
      return null;
    }

    for (let i = 0; i < variations.length; i++) {
      const variation = variations[i];

      if (!variation || !variation.attributes) {
        continue;
      }

      const attributes = variation.attributes;
      let match = true;

      // Check if variation matches all selected attributes
      for (const attrName in attributesData) {
        if (
          attributesData.hasOwnProperty(attrName) &&
          attributesData[attrName] !== ""
        ) {
          const attrValue = attributesData[attrName];

          // Skip if variation doesn't define this attribute
          if (typeof attributes[attrName] === "undefined") {
            continue;
          }

          // If variation attribute is empty, it matches any value
          if (attributes[attrName] === "") {
            continue;
          }

          // Check for exact match
          if (attributes[attrName] !== attrValue) {
            match = false;
            break;
          }
        }
      }

      // Return variation if we found a match
      if (match && variation.is_in_stock && variation.is_purchasable) {
        return variation;
      }
    }

    return null;
  }

  // Find matching variation via AJAX
  findMatchingVariationOnServer(attributesData, callback) {
    if (typeof usk_vars === "undefined" || !usk_vars.ajax_url) {
      callback(null);
      return;
    }

    // Format attributes for AJAX
    const formattedAttributes = {};
    for (const key in attributesData) {
      if (attributesData.hasOwnProperty(key) && attributesData[key]) {
        const attrName = key.replace("attribute_", "");
        formattedAttributes[attrName] = attributesData[key];
      }
    }

    jQuery.ajax({
      url: usk_vars.ajax_url,
      type: "POST",
      data: {
        action: "usk_get_available_variations",
        product_id: this.productId,
        attributes: formattedAttributes,
        security: usk_vars.nonce || "",
      },
      success: (response) => {
        if (response && response.success && response.data) {
          callback(response.data.variation_id, response.data);
        } else {
          callback(null);
        }
      },
      error: () => {
        callback(null);
      },
    });
  }

  // Get chosen attributes from container
  getChosenAttributes() {
    const data = {};
    let count = 0;
    let chosen = 0;

    // Get attributes from variation swatches
    if (this.$swatchWrappers && this.$swatchWrappers.length) {
      this.$swatchWrappers.each((i, wrapper) => {
        const $wrapper = jQuery(wrapper);
        const attributeName = $wrapper.data("attribute_name");

        if (!attributeName) {
          return true; // Skip this iteration
        }

        const $selected = $wrapper.find(
          ".usk-variation-swatches__item.selected"
        );
        const value = $selected.length ? $selected.data("value") : "";

        if (value) {
          chosen++;
        }

        count++;
        data[attributeName] = value;
      });
    }

    // Get attributes from variation buttons
    if (this.$container) {
      this.$container.find(".usk-variation-group").each((i, group) => {
        const $group = jQuery(group);
        const $activeBtn = $group.find(".usk-variation-button.active");

        if (!$activeBtn.length) {
          return true;
        }

        const attribute = $activeBtn.data("attribute");
        if (!attribute) {
          return true;
        }

        const attributeName = "attribute_" + attribute;
        const value = $activeBtn.data("value") || "";

        // Only add if not already set by swatches
        if (!data[attributeName]) {
          if (value) {
            chosen++;
          }

          count++;
          data[attributeName] = value;
        }
      });
    }

    return {
      count: count,
      chosenCount: chosen,
      data: data,
    };
  }

  // Get total number of required attributes
  getTotalRequiredAttributes() {
    let count = 0;

    // Count variation swatches
    if (this.$swatchWrappers && this.$swatchWrappers.length) {
      this.$swatchWrappers.each((i, wrapper) => {
        const $wrapper = jQuery(wrapper);
        if ($wrapper.data("attribute_name")) {
          count++;
        }
      });
    }

    // Count variation buttons in groups that aren't already counted
    const countedAttributes = new Set();
    this.$swatchWrappers.each((i, wrapper) => {
      const attrName = jQuery(wrapper).data("attribute_name");
      if (attrName) {
        countedAttributes.add(attrName.replace('attribute_', ''));
      }
    });

    this.$container.find(".usk-variation-group").each((i, group) => {
      const $group = jQuery(group);
      const $firstBtn = $group.find(".usk-variation-button").first();
      const attribute = $firstBtn.data("attribute");

      if (attribute && !countedAttributes.has(attribute)) {
        count++;
      }
    });

    return count;
  }
}

// Initialize on document ready
jQuery(function ($) {
  function initGridVariations() {
    $(".usk-variations-container:not(.swatches-support)").each(function () {
      new USKGridVariations($(this));
    });
  }

  // Initialize on page load
  initGridVariations();

  // Reinitialize after cart operations
  $(document.body).on(
    "wc_fragments_refreshed wc_fragments_loaded added_to_cart",
    initGridVariations
  );

  // Initialize on AJAX content load
  $(document).ajaxComplete(function (event, xhr, settings) {
    setTimeout(function () {
      initGridVariations();
    }, 100);
  });
});
