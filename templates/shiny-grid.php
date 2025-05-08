<?php

/**
 * Shiny Grid Template Class
 *
 * Handles rendering of product items in the Shiny Grid layout
 */

namespace UltimateStoreKit\Templates;

use UltimateStoreKit\Traits\Global_Widget_Template;

class USK_Shiny_Grid_Template {
    use Global_Widget_Template;

    /**
     * Widget settings and name
     */
    protected $target_widget_settings = [];
    protected $target_widget_name = '';

    /**
     * Constructor
     */
    public function __construct($settings = [], $widget_name = '') {
        $this->target_widget_settings = $settings;
        $this->target_widget_name = $widget_name;
    }

    /**
     * Render a single product item
     */
    public function render_shiny_grid_item($product, $settings) {
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
                <?php $this->render_product_variation($product); ?>

                <div class="usk-content">
                    <div class="usk-content-inner">
                        <?php if ($categories && (isset($settings['show_category']) ? $settings['show_category'] : true)) : ?>
                            <div class="usk-category"><?php echo wp_kses_post($categories); ?></div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_title']) ? $settings['show_title'] : true) : ?>
                            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="usk-title">
                                <h3 class="title"><?php echo esc_html(get_the_title($product_id)); ?></h3>
                            </a>
                        <?php endif; ?>

                        <?php if (isset($settings['show_desc']) ? $settings['show_desc'] : true) : ?>
                            <div class="usk-desc">
                                <span class="desc"><?php echo wp_kses_post(wp_trim_words($product->get_short_description(), 15, '…')); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_price']) ? $settings['show_price'] : true && $product->get_price_html()) : ?>
                            <div class="usk-price">
                                <?php $this->print_price_output($product->get_price_html()); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_rating']) ? $settings['show_rating'] : true) : ?>
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
    public function render_add_to_cart_button($product) {
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
            $button_text = $has_default_attributes ? \__('Add to cart', 'woocommerce') : \__('Select options', 'woocommerce');
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

    /**
     * Get variation ID from product attributes
     */
    private function get_variation_id_from_attributes($product, $attributes) {
        if (!$product->is_type('variable')) {
            return null;
        }

        $variations = $product->get_available_variations();

        foreach ($variations as $variation) {
            $match = true;

            foreach ($attributes as $attribute_name => $attribute_value) {
                $taxonomy = 'attribute_' . $attribute_name;

                if (
                    !isset($variation['attributes'][$taxonomy]) ||
                    $variation['attributes'][$taxonomy] !== $attribute_value
                ) {
                    $match = false;
                    break;
                }
            }

            if ($match) {
                return $variation['variation_id'];
            }
        }

        return null;
    }

    /**
     * Render product image with hover effect and action buttons
     */
    public function render_product_image($product) {
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
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
            <?php $this->render_add_to_cart_button($product); ?>
            <div class="usk-shoping">
                <?php $this->register_global_template_add_to_wishlist($tooltip_position, $settings); ?>
                <?php $this->register_global_template_add_to_compare($tooltip_position, $settings); ?>
                <?php $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings); ?>
            </div>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content usk-flex usk-flex-column">
                    <?php $this->register_global_template_badge_label($settings); ?>
                </div>
            </div>
            <!-- display product variation -->
        </div>
<?php
    }

    /**
     * Print price HTML with allowed tags
     */
    public function print_price_output($output) {
        $allowed_tags = [
            'del' => ['aria-hidden' => []],
            'span'  => ['class' => []],
            'bdi' => [],
            'ins' => [],
        ];

        if (isset($output)) {
            echo wp_kses($output, $allowed_tags);
        }
    }

    /**
     * Render product variation options (colors, sizes)
     *
     * Displays variation swatches on product grid items
     * When a user selects a variation, it becomes active and ready for add to cart
     */
    public function render_product_variation($product) {
        if (!$product || !$product->is_type('variable')) {
            return;
        }

        $variations = $product->get_available_variations();
        if (empty($variations)) {
            return;
        }

        // Get default attributes
        $default_attributes = $product->get_default_attributes();

        // Get all attribute taxonomies for this product
        $attributes = $product->get_attributes();
        $product_id = $product->get_id();

        echo '<div class="usk-variations-container">';

        // Display color variations
        $colors = [];
        foreach ($variations as $variation) {
            if (isset($variation['attributes']['attribute_pa_color'])) {
                $color = $variation['attributes']['attribute_pa_color'];

                if (!in_array($color, $colors)) {
                    $colors[] = $color;
                    $variation_id = $variation['variation_id'];

                    // Check if this is the default color
                    $is_default = isset($default_attributes['pa_color']) && $default_attributes['pa_color'] === $color;
                    $active_class = $is_default ? ' active' : '';

                    // Get the color term to find if there's any color value
                    $color_term = \get_term_by('slug', $color, 'pa_color');
                    $color_value = '';
                    if ($color_term) {
                        $color_value = $color_term->slug;
                    }

                    $style = '';
                    if ($color_value) {
                        $style = 'style="background-color:' . \esc_attr($color_value) . ';"';
                    }


                    echo '<button type="button" class="usk-variation-button usk-color-variation' . \esc_attr($active_class) . '" ' .
                        'data-variation-id="' . \esc_attr($variation_id) . '" ' .
                        'data-product-id="' . \esc_attr($product_id) . '" ' .
                        'data-attribute="pa_color" ' .
                        'data-value="' . \esc_attr($color) . '" ' .
                        $style . '>' .
                        ($color_value ? '' : \esc_html($color)) .
                        '</button>';
                }
            }
        }

        // Display size variations
        $sizes = [];
        foreach ($variations as $variation) {
            if (isset($variation['attributes']['attribute_pa_size'])) {
                $size = $variation['attributes']['attribute_pa_size'];

                if (!in_array($size, $sizes)) {
                    $sizes[] = $size;
                    $variation_id = $variation['variation_id'];

                    // Check if this is the default size
                    $is_default = isset($default_attributes['pa_size']) && $default_attributes['pa_size'] === $size;
                    $active_class = $is_default ? ' active' : '';

                    echo '<button type="button" class="usk-variation-button usk-size-variation' . \esc_attr($active_class) . '" ' .
                        'data-variation-id="' . \esc_attr($variation_id) . '" ' .
                        'data-product-id="' . \esc_attr($product_id) . '" ' .
                        'data-attribute="pa_size" ' .
                        'data-value="' . \esc_attr($size) . '">' .
                        \esc_html($size) .
                        '</button>';
                }
            }
        }

        // Handle sweatshirt variations (or any custom product attribute)
        foreach ($attributes as $attribute_name => $attribute) {
            // Skip already processed attributes
            if ($attribute_name === 'pa_color' || $attribute_name === 'pa_size') {
                continue;
            }

            // Skip non-variation attributes
            if (!$attribute->get_variation()) {
                continue;
            }

            // Only continue for product attributes (taxonomy based)
            if (!$attribute->is_taxonomy()) {
                continue;
            }

            $attribute_values = [];
            $attribute_label = \wc_attribute_label($attribute_name);

            // Create a container for this attribute type
            echo '<div class="usk-variation-group usk-' . \esc_attr(\sanitize_title($attribute_name)) . '-group">';
            echo '<span class="usk-variation-label">' . \esc_html($attribute_label) . '</span>';

            foreach ($variations as $variation) {
                $taxonomy_key = 'attribute_' . $attribute_name;
                if (isset($variation['attributes'][$taxonomy_key])) {
                    $value = $variation['attributes'][$taxonomy_key];

                    if (!in_array($value, $attribute_values)) {
                        $attribute_values[] = $value;
                        $variation_id = $variation['variation_id'];

                        // Check if this is the default value
                        $is_default = isset($default_attributes[$attribute_name]) && $default_attributes[$attribute_name] === $value;
                        $active_class = $is_default ? ' active' : '';

                        // Get term data
                        $term = \get_term_by('slug', $value, $attribute_name);
                        $display_value = $term ? $term->name : $value;

                        echo '<button type="button" class="usk-variation-button usk-' . \esc_attr(\sanitize_title($attribute_name)) . '-variation' . \esc_attr($active_class) . '" ' .
                            'data-variation-id="' . \esc_attr($variation_id) . '" ' .
                            'data-product-id="' . \esc_attr($product_id) . '" ' .
                            'data-attribute="' . \esc_attr($attribute_name) . '" ' .
                            'data-value="' . \esc_attr($value) . '">' .
                            \esc_html($display_value) .
                            '</button>';
                    }
                }
            }

            echo '</div>';
        }

        echo '</div>';
    }
}
