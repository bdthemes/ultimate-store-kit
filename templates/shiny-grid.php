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
     * Target widget settings
     *
     * @var array
     */
    protected $target_widget_settings = [];

    /**
     * Constructor
     *
     * @param array $settings Widget settings
     */
    public function __construct($settings = []) {
        $this->target_widget_settings = $settings;
    }

    /**
     * Render a single product item specifically for the Shiny Grid widget
     *
     * @param WC_Product $product The product object to render
     * @param array $settings The widget settings
     */
    public function render_shiny_grid_item($product, $settings) {
        if (!$product) {
            return;
        }
        $product_id = $product->get_id();
        $rating_count = $product->get_rating_count();
        $average = $product->get_average_rating();

        // Get product image
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id($product_id), 'medium');

        // Get gallery image for hover effect
        $gallery_image_link = $product_image; // Default to same image
        $gallery_thumbs = $product->get_gallery_image_ids();
        if (!empty($gallery_thumbs)) {
            $gallery_image_link = wp_get_attachment_image_url($gallery_thumbs[0], 'medium');
        }

        // Get product categories
        $categories = wc_get_product_category_list($product_id);

        // Determine if we should show rating class
        $show_rating = isset($settings['show_rating']) ? $settings['show_rating'] : true;
        $have_rating = ($show_rating) ? 'usk-have-rating' : '';
?>
        <div class="usk-item <?php echo esc_attr($have_rating); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
            <div class="usk-item-box">
                <?php $this->render_product_image($product); ?>

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

                        <?php if ($settings['show_desc'] === 'yes') : ?>
                            <div class="usk-desc">
                                <span class="desc"><?php echo wp_kses_post(wp_trim_words($product->get_short_description(), 15, '…')); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($settings['show_price']) ? $settings['show_price'] : true && $product->get_price_html()) : ?>
                            <div class="usk-price">
                                <?php echo wp_kses_post($product->get_price_html()); ?>
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
     *
     * @param WC_Product $product The product object
     */
    public function render_add_to_cart_button($product) {
        if (!$product) {
            return;
        }

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

        echo apply_filters(
            'woocommerce_loop_add_to_cart_link',
            sprintf(
                '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon usk-icon-arrow-right-8"></i></a>',
                esc_url($product->add_to_cart_url()),
                esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                esc_html($product->add_to_cart_text())
            ),
            $product,
            $args
        );
    }

    /**
     * Render product image with hover effect and action buttons
     *
     * @param WC_Product $product The product object
     */
    public function render_product_image($product) {
        if (!$product) {
            return;
        }

        $tooltip_position = 'left';
        $settings = $this->target_widget_settings;
        $gallery_thumbs = $product->get_gallery_image_ids();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
        if ($gallery_thumbs) {
            foreach ($gallery_thumbs as $key => $gallery_thumb) {
                if ($key == 0) :
                    $gallery_image_link = wp_get_attachment_image_url($gallery_thumb, $settings['image_size']);
                endif;
            }
        } else {
            $gallery_image_link = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size']);
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
        </div>
<?php
    }
}
