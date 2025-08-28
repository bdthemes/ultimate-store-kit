<?php

/**
 * Shiny Grid Template Class
 *
 * Handles rendering of product items in the Shiny Grid layout
 */

namespace UltimateStoreKit\Templates;

use UltimateStoreKit\Traits\Global_Widget_Template;

class USK_Shiny_Grid_Template
{
    use Global_Widget_Template;

    /**
     * Widget settings and name
     */
    protected $target_widget_settings = [];
    protected $target_widget_name = '';

    /**
     * Constructor
     */
    public function __construct($settings = [], $widget_name = '')
    {
        $this->target_widget_settings = $settings;
        $this->target_widget_name = $widget_name;
    }

    /**
     * Render a single product item
     */
    public function render_shiny_grid_item($product, $settings)
    {
        if (!$product) {
            return;
        }

        $product_id = $product->get_id();
        $rating_count = $product->get_rating_count();
        $average = $product->get_average_rating();
        $categories = wc_get_product_category_list($product_id, ' ');

        $show_rating = isset($settings['show_rating']) ? $settings['show_rating'] : true;
        $classes = $this->target_widget_name === 'shiny-grid' ? 'usk-item' : 'usk-item swiper-slide';
        $classes .= $show_rating ? ' usk-have-rating' : '';
        ?>
        <div class="<?php echo esc_attr($classes); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
            <div class="usk-item-box">
                <?php $this->render_product_image($product); ?>
                <div class="usk-content">
                    <?php if (isset($settings['show_variation']) && $settings['show_variation'] === 'yes'): ?>
                        <?php $this->render_product_variation($product, $settings);
                        ?>
                    <?php endif; ?>
                    <div class="usk-content-inner">
                        <?php if ($categories && (isset($settings['show_category']) ? $settings['show_category'] : true)): ?>
                            <div class="usk-category"><?php echo wp_kses_post($categories); ?></div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_title']) ? $settings['show_title'] : true): ?>
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="usk-title">
                                <h3 class="title"><?php echo esc_html(get_the_title($product_id)); ?></h3>
                            </a>
                        <?php endif; ?>

                        <?php if (
                            (isset($settings['show_excerpt']) ? $settings['show_excerpt'] : true)
                            && isset($settings['layout_style']) && $settings['layout_style'] === 'list'
                        ): ?>
                            <div class="usk-desc">
                                <span class="desc">
                                    <?php echo wp_kses_post(wp_trim_words($product->get_short_description(), $settings['excerpt_limit'], '…')); ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_price']) ? $settings['show_price'] : true && $product->get_price_html()): ?>
                            <div class="usk-price">
                                <?php $this->print_price_output($product->get_price_html()); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_rating']) ? $settings['show_rating'] : true): ?>
                            <div class="usk-rating">
                                <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Render add to cart button
     */
    public function __render_add_to_cart_button($product)
    {
        if (!$product) {
            return;
        }

        // Check if product is variable and has default attributes
        $has_default_attributes = false;
        if ($product->is_type('variable')) {
            $default_attributes = $product->get_default_attributes();
            if (!empty($default_attributes)) {
                $has_default_attributes = true;
            }
        }

        // Set up button classes
        $button_classes = [
            'usk-button',
            'product_type_' . $product->get_type(),
        ];

        // Add appropriate classes for purchasable products
        if ($product->is_purchasable() && $product->is_in_stock() && (!$product->is_type('variable') || $has_default_attributes)) {
            $button_classes[] = 'add_to_cart_button';

            if ($product->supports('ajax_add_to_cart')) {
                $button_classes[] = 'ajax_add_to_cart';
            }
        }

        // Set up button attributes
        $button_attributes = [
            'data-product_id' => $product->get_id(),
            'data-product_sku' => $product->get_sku(),
            'aria-label' => $product->add_to_cart_description(),
            // 'rel' => 'nofollow',
        ];

        // Add default attributes data for variable products
        if ($product->is_type('variable') && $has_default_attributes) {
            $button_attributes['data-default_attributes'] = htmlspecialchars(
                \wp_json_encode($product->get_default_attributes()),
                ENT_QUOTES,
                'UTF-8'
            );

            $variation_id = $this->get_variation_id_from_attributes($product, $product->get_default_attributes());
            if ($variation_id) {
                $button_attributes['data-variation_id'] = $variation_id;

                // Add each default attribute as separate data attributes for AJAX support
                foreach ($default_attributes as $attribute_name => $attribute_value) {
                    $button_attributes['data-attribute_' . $attribute_name] = $attribute_value;
                }

                // If we have a default variation, use product_type_variation instead of variable
                if (in_array('product_type_variable', $button_classes)) {
                    $key = array_search('product_type_variable', $button_classes);
                    if ($key !== false) {
                        $button_classes[$key] = 'product_type_variation';
                    }
                }
            }
        }

        // Create button args
        $args = [
            'quantity' => 1,
            'class' => implode(' ', $button_classes),
            'attributes' => $button_attributes,
        ];

        $args = \apply_filters('woocommerce_loop_add_to_cart_args', $args, $product);

        // Clean up aria-label
        if (isset($args['attributes']['aria-label'])) {
            $args['attributes']['aria-label'] = \wp_strip_all_tags($args['attributes']['aria-label']);
        }

        // Determine button text
        if ($product->is_type('variable')) {
            $button_text = $has_default_attributes ? \__('Add to cart', 'ultimate-store-kit') : \__('Select options', 'ultimate-store-kit');
        } else {
            $button_text = $product->add_to_cart_text();
        }

        // Get the URL
        if ($product->is_type('variable')) {
            $url = 'javascript:void(0)';
        } else {
            $url = $product->add_to_cart_url();
        }

        // Make sure variable products use correct classes
        if ($product->is_type('variable') && in_array('product_type_variable', $button_classes)) {
            $key = array_search('product_type_variable', $button_classes);
            if ($key !== false) {
                $button_classes[$key] = 'product_type_variation';
            }
        }

        // Output the button
        echo \apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon usk-icon-arrow-right-8"></i></a>',
                \esc_url($url),
                \esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                \esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                isset($args['attributes']) ? \wc_implode_html_attributes($args['attributes']) : '',
                \esc_html($button_text)
            ),
            $product,
            $args
        );
    }
    public function render_add_to_cart_button($product, $settings)
    {
        if ($product) {
            $defaults = [
                'quantity' => 1,
                'class' => implode(
                    ' ',
                    array_filter(
                        [
                            'usk-button',
                            'product_type_' . $product->get_type(),
                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                            $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                        ]
                    )
                ),
                'attributes' => [
                    'data-product_id' => $product->get_id(),
                    'data-product_sku' => $product->get_sku(),
                    'aria-label' => $product->add_to_cart_description(),
                    'rel' => 'nofollow',
                ],
            ];
            $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
            if (isset($args['attributes']['aria-label'])) {
                $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
            }

            if ( isset( $settings['show_cart'] ) ? $settings['show_cart'] : true ) {
                echo wp_kses_post(apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon usk-icon-arrow-right-8"></i></a>',
                        esc_url( $product->add_to_cart_url() ),
                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                        esc_attr( isset($args['class'] ) ? $args['class'] : 'button' ),
                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                        esc_html( $product->add_to_cart_text() )
                    ),
                    $product,
                    $args
                ));
            }
        }
        ;
    }

    /**
     * Get variation ID from product attributes
     * Uses WooCommerce data store for reliable variation finding
     */
    private function get_variation_id_from_attributes($product, $attributes)
    {
        if (!$product || !$product->is_type('variable')) {
            return null;
        }

        // Format attributes for WooCommerce
        $formatted_attributes = [];
        foreach ($attributes as $attribute_name => $attribute_value) {
            $formatted_attributes['attribute_' . $attribute_name] = $attribute_value;
        }

        // Use WooCommerce's data store to find matching variation
        $data_store = \WC_Data_Store::load('product');
        $variation_id = $data_store->find_matching_product_variation($product, $formatted_attributes);

        if ($variation_id) {
            return $variation_id;
        }

        return null;
    }

    /**
     * Render product image with hover effect and action buttons
     */
    public function render_product_image($product)
    {
        if (!$product) {
            return;
        }

        $tooltip_position = 'left';
        $settings = $this->target_widget_settings;
        $image_size = isset($settings['image_size']) ? $settings['image_size'] : 'full';

        // Get main product image
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $image_size);

        // Get gallery image for hover effect
        $gallery_image_link = $product_image; // Default to main image
        $gallery_thumbs = $product->get_gallery_image_ids();

        if ($gallery_thumbs && !empty($gallery_thumbs[0])) {
            $gallery_image_link = wp_get_attachment_image_url($gallery_thumbs[0], $image_size);
        }
        ?>
        <div class="usk-image">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>"
                    alt="<?php echo esc_html(get_the_title()); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>"
                    alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
            <?php $this->render_add_to_cart_button($product, $settings); ?>

            <div class="usk-shoping">
                <?php $this->register_global_template_add_to_wishlist($tooltip_position, $settings); ?>
                <?php $this->register_global_template_add_to_compare($tooltip_position, $settings); ?>
                <?php $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings); ?>
            </div>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content usk-flex usk-flex-column">
                    <?php $this->register_global_template_badge_label($settings); ?>
                </div>

                <!-- display product variation -->
            </div>
        </div>
        <?php
    }

    /**
     * Print price HTML with allowed tags
     */
    public function print_price_output($output)
    {
        $allowed_tags = [
            'del' => ['aria-hidden' => []],
            'span' => ['class' => []],
            'bdi' => [],
            'ins' => [],
        ];

        if (isset($output)) {
            echo wp_kses($output, $allowed_tags);
        }
    }

    /**
     * Check if swatches support is available
     */
    private function has_swatches_support()
    {
        return class_exists('UltimateStoreKitPro\\VariationSwatches\\Swatches');
    }

    /**
     * Render product variation options (colors, sizes)
     * Displays variation swatches on product grid items
     */
    public function render_product_variation($product, $settings)
    {
        if (!$product || !$product->is_type('variable')) {
            return;
        }

        $variations = $product->get_available_variations();
        if (empty($variations)) {
            return;
        }

        // Check if sequential mode is enabled
        $sequential = \apply_filters('usk_sequential_variations', isset($settings['show_variation_sequential']) && $settings['show_variation_sequential'] === 'yes');

        // If Pro version with swatches is active, use that functionality
        if ($this->has_swatches_support() && function_exists('apply_filters')) {
            $this->render_swatches_variation($product, $variations, $sequential);
            return;
        }

        // Otherwise use the simple variation buttons
        $this->render_simple_variations($product, $variations, $sequential);
    }

    /**
     * Render simple variation buttons for the free version
     */
    private function render_simple_variations($product, $variations, $sequential = false)
    {
        $product_id = $product->get_id();
        $attributes = $product->get_variation_attributes();

        if (empty($attributes)) {
            return;
        }

        // Add sequential data attribute if enabled
        $sequential_attr = $sequential ? ' data-sequential="true"' : '';

        echo '<div class="usk-variations-container" data-product-id="' . esc_attr($product_id) . '" data-variations-reset="true"' . $sequential_attr . '>';

        foreach ($attributes as $attribute_name => $options) {
            if (empty($options)) {
                continue;
            }

            // Get attribute label
            $attribute_label = wc_attribute_label($attribute_name);
            $attribute_slug = sanitize_title($attribute_name);

            echo '<div class="usk-variation-group">';
            echo '<div class="usk-variation-options">';

            foreach ($options as $option) {
                $classes = 'usk-variation-button';
                $option_name = apply_filters('woocommerce_variation_option_name', $option);

                // Check if this is a color attribute
                $is_color = (strpos(strtolower($attribute_slug), 'color') !== false ||
                    strpos(strtolower($attribute_label), 'color') !== false);

                if ($is_color) {
                    // For color attributes, use background color and minimal text
                    // Translators: %s is the name of the color option (e.g., "Red", "Blue").
                    $aria_label = sprintf( __( 'Select %s', 'ultimate-store-kit' ), esc_attr( $option_name ) );
                    echo '<button type="button" class="' . esc_attr($classes . ' usk-color-button') . '"
                            data-attribute="' . esc_attr($attribute_slug) . '"
                            data-value="' . esc_attr($option) . '"
                            style="background-color: ' . esc_attr($option) . '"
                            aria-label="' . esc_attr($aria_label) . '"><span class="usk-tooltip-text">' . esc_html($option_name) . '</span>
                        </button>';
                } else {
                    // For non-color attributes, display as regular text buttons
                    // Translators: %s is the name of the variation option (e.g., "Large", "Cotton").
                    $aria_label = sprintf( __( 'Select %s', 'ultimate-store-kit' ), esc_attr( $option_name ) );
                    echo '<button type="button" class="' . esc_attr($classes) . '"
                            data-attribute="' . esc_attr($attribute_slug) . '"
                            data-value="' . esc_attr($option) . '"
                            aria-label="' . esc_attr($aria_label) . '">' . esc_html($option_name) . '<span class="usk-tooltip-text">' . esc_html($option_name) . '</span>
                        </button>';
                }
            }

            echo '</div>'; // Close .usk-variation-options
            echo '</div>'; // Close .usk-variation-group
        }

        echo '</div>'; // Close .usk-variations-container
    }

    /**
     * Render variation swatches using the Pro version's swatches functionality
     */
    private function render_swatches_variation($product, $variations, $sequential = false)
    {
        $product_id = $product->get_id();
        $attributes = $product->get_variation_attributes();

        if (empty($attributes)) {
            return;
        }

        // Add sequential data attribute if enabled
        $sequential_attr = $sequential ? ' data-sequential="true"' : '';

        echo '<div class="usk-variations-container usk-pro-swatches" data-product-id="' . esc_attr($product_id) . '" data-variations-reset="true"' . $sequential_attr . '>';

        // Loop through each product attribute
        foreach ($attributes as $attribute_name => $options) {
            if (empty($options)) {
                continue;
            }

            echo '<div class="usk-variation-group">';

            // Build the args for the swatches
            $args = array(
                'options' => $options,
                'product' => $product,
                'attribute' => $attribute_name,
                'name' => 'attribute_' . sanitize_title($attribute_name),
                'selected' => isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])
                    ? wc_clean(wp_unslash($_REQUEST['attribute_' . sanitize_title($attribute_name)]))
                    : $product->get_variation_default_attribute($attribute_name)
            );

            // Create a placeholder for the dropdown - this will be replaced with swatches
            $dropdown_html = '<select id="' . esc_attr($args['name']) . '" class="' . esc_attr($args['name']) . '" name="' . esc_attr($args['name']) . '" data-attribute_name="' . esc_attr($args['name']) . '" data-show_option_none="yes" style="display:none;">';
            $dropdown_html .= '<option value="">' . esc_html__('Choose an option', 'ultimate-store-kit') . '</option>';

            if (!empty($options)) {
                foreach ($options as $option) {
                    $dropdown_html .= '<option value="' . esc_attr($option) . '" ' . selected($args['selected'], $option, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute_name, $product)) . '</option>';
                }
            }

            $dropdown_html .= '</select>';

            // Apply the filter to transform the dropdown to swatches
            if (class_exists('UltimateStoreKitPro\\VariationSwatches\\Swatches')) {
                $swatches = \UltimateStoreKitPro\VariationSwatches\Swatches::instance();
                $swatches_html = $swatches->swatches_html($dropdown_html, $args);
                echo $swatches_html;
            } else {
                echo $dropdown_html;
            }

            echo '</div>'; // Close .usk-variation-group
        }

        echo '</div>'; // Close .usk-variations-container
    }
}
