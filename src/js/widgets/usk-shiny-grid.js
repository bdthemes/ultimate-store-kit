; (function ($, elementor) {
    'use strict';
    var GridColumn = function ($scope, $) {
        $scope.find('*[data-filter="yes"]').each(function () {
            var $element = $(this)[0];
            var filter = $(this).data('filter');
            if ($element) {
                if (filter === 'yes') {
                    $('.tab-option').on('click', function (e) {
                        var grid_column = $(this).data('grid-column');
                        var set_grid_data = localStorage.setItem('usk_grid_data', grid_column);
                        $(this).closest('.usk-grid-header').find('li').removeClass('usk-tabs-active');
                        $(this).parent().addClass('usk-tabs-active');
                        if (grid_column !== 'usk-list-2') {
                            $(this).closest('.usk-grid-header').parent().find('.usk-grid').removeClass().addClass('usk-grid usk-grid-layout ' + grid_column);
                        } else {
                            $(this).closest('.usk-grid-header').parent().find('.usk-grid').removeClass().addClass('usk-grid usk-list-layout ' + grid_column);
                        }
                    });
                    var editMode = Boolean(elementor.isEditMode());
                    if (!editMode) {
                        var get_grid_data = localStorage.getItem('usk_grid_data');
                        if (get_grid_data !== null) {
                            $("[data-grid-column=" + get_grid_data + "]").parent().addClass('usk-tabs-active');
                            if (get_grid_data !== 'usk-list-2') {
                                $(this).find('.usk-grid').removeClass().addClass('usk-grid usk-grid-layout ' + get_grid_data);
                            } else {
                                $(this).find('.usk-grid').removeClass().addClass('usk-grid usk-list-layout ' + get_grid_data);
                            }
                        }
                    }
                }
            }
        });

        // Product variation selection
        $scope.find('.usk-variation-button').on('click', function(e) {
            e.preventDefault();

            var $this = $(this);
            var product_id = $this.data('product-id');
            var attribute = $this.data('attribute');
            var value = $this.data('value');
            var variation_id = $this.data('variation-id');

            // Remove active class from all buttons in the same attribute group
            $('.usk-variation-button[data-attribute="' + attribute + '"][data-product-id="' + product_id + '"]').removeClass('active');

            // Add active class to the clicked button
            $this.addClass('active');

            // Get product container
            var $productContainer = $('.usk-item[data-product-id="' + product_id + '"]');

            // Get all selected attributes for this product
            var allAttributes = {};
            $productContainer.find('.usk-variation-button.active').each(function() {
                var attr = $(this).data('attribute');
                var val = $(this).data('value');
                allAttributes[attr] = val;
            });

            // Update add to cart button
            var $addToCartBtn = $productContainer.find('.usk-button');

            if ($addToCartBtn.length) {
                // Clear previous data attributes
                $.each($addToCartBtn[0].attributes, function() {
                    if (this.name.indexOf('data-attribute_') === 0) {
                        $addToCartBtn.removeAttr(this.name);
                    }
                });

                // Update button data attributes
                $addToCartBtn.attr('data-variation_id', variation_id);
                $addToCartBtn.attr('data-product_id', product_id);

                // Add attribute data for AJAX add to cart
                for (var attr in allAttributes) {
                    if (allAttributes.hasOwnProperty(attr)) {
                        $addToCartBtn.attr('data-attribute_' + attr, allAttributes[attr]);
                    }
                }

                // Update button classes for WooCommerce AJAX
                $addToCartBtn.addClass('add_to_cart_button ajax_add_to_cart');
                $addToCartBtn.removeClass('product_type_variable');
                $addToCartBtn.addClass('product_type_variation');

                // Update button text
                $addToCartBtn.html('Add to cart <i class="button-icon usk-icon-arrow-right-8"></i>');

                // Create the most reliable URL for fallback
                var url = '?add-to-cart=' + product_id + '&variation_id=' + variation_id;
                for (var attr in allAttributes) {
                    if (allAttributes.hasOwnProperty(attr)) {
                        url += '&attribute_' + attr + '=' + encodeURIComponent(allAttributes[attr]);
                    }
                }
                $addToCartBtn.attr('href', url);
            }

            // Update product image if color is selected
            if (attribute === 'pa_color') {
                // Get the variation data
                $.ajax({
                    url: woocommerce_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'get_variation_data',
                        product_id: product_id,
                        variation_id: variation_id
                    },
                    success: function(response) {
                        if (response.success && response.data) {
                            // If we have variation image data
                            if (response.data.image && response.data.image.src) {
                                // Update both default and hover images
                                $productContainer.find('.image-default').attr('src', response.data.image.src);

                                // For hover image, use either additional image from variation or keep existing
                                if (response.data.additional_image) {
                                    $productContainer.find('.image-hover').attr('src', response.data.additional_image);
                                }
                            }
                        }
                    }
                });

                // Find the active color swatch's background color
                var bgColor = $this.css('background-color');
                if (bgColor && bgColor !== 'transparent' && bgColor !== 'rgba(0, 0, 0, 0)') {
                    // Add a class indicating the selected color
                    $productContainer.attr('data-selected-color', value);
                }
            }
        });

        // Fix add to cart for variations - prevent multiple triggers
        // First, remove any existing handlers to avoid duplicates
        $(document.body).off('click', '.usk-shiny-grid .usk-button.product_type_variation');

        // Then add our custom handler with a flag to prevent multiple submissions
        $(document.body).on('click', '.usk-shiny-grid .usk-button.product_type_variation', function(e) {

            var $button = $(this);

            // Check if button is already processing to prevent multiple clicks
            if ($button.hasClass('loading') || $button.hasClass('processing')) {
                return false;
            }

            // Mark button as processing
            $button.addClass('processing');

            // Only proceed if button has required data
            if (!$button.data('variation_id') || !$button.data('product_id')) {
                $button.removeClass('processing');
                return true; // Let default handler take over
            }

            // Extract all required attributes
            var data = {
                'product_id': $button.data('product_id'),
                'variation_id': $button.data('variation_id'),
                'quantity': $button.data('quantity') || 1
            };

            // Get all attribute data
            $.each($button[0].attributes, function() {
                if (this.name.startsWith('data-attribute_')) {
                    var key = this.name.substring(5); // Remove 'data-' prefix
                    data[key] = this.value;
                }
            });

            // Show loading state
            $button.addClass('loading');

            // Perform the AJAX request
            $.ajax({
                type: 'POST',
                url: woocommerce_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart'),
                data: data,
                success: function(response) {
                    alert('success');
                    if (!response) {
                        $button.removeClass('loading processing');
                        return;
                    }

                    if (response.error) {
                        // Handle error case - redirect to product page
                        window.location = $button.attr('href');
                        return;
                    }

                    // Trigger WooCommerce's events to update cart fragments
                    $(document.body).trigger('wc_fragment_refresh');
                    // $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
                    //prevent default
                    e.preventDefault();

                    // Update button state
                    $button.removeClass('loading').addClass('added');

                    // Show a success message
                    var $productContainer = $button.closest('.usk-item');

                    // Create and append success notification
                    var $notification = $('<div class="usk-cart-success-message">Product added to cart! ✓</div>');
                    $productContainer.append($notification);

                    // Auto remove after delay
                    setTimeout(function() {
                        $notification.fadeOut(300, function() {
                            $(this).remove();
                            // Remove processing class after animation completes
                            $button.removeClass('processing');
                        });
                    }, 2000);
                },
                error: function() {
                    // On failure, remove processing class
                    $button.removeClass('loading processing');
                    // Redirect to the fallback URL
                    window.location = $button.attr('href');
                }
            });

            return false;
        });

        // Disable WooCommerce's default AJAX handler for our variation buttons
        $(document.body).off('click', '.usk-shiny-grid .ajax_add_to_cart.product_type_variation');
    };

    jQuery(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/usk-shiny-grid.default', GridColumn);
        // elementorFrontend.hooks.addAction('frontend/element_ready/usk-glossy-grid.default', GridColumn);
        // elementorFrontend.hooks.addAction('frontend/element_ready/usk-florence-grid.default', GridColumn);
    });

}(jQuery, window.elementorFrontend));