<?php

/**
 * Glossy Grid Template Class
 *
 * Handles rendering of product items in the Glossy Grid layout
 */


namespace UltimateStoreKit\Templates;

use UltimateStoreKit\Traits\Global_Widget_Template;


class USK_Glossy_Grid_Template
{
    use Global_Widget_Template;
    /**
     * Target widget settings
     *
     * @var array
     */
    protected $target_widget_settings = [];
    protected $target_widget_name = '';
    /**
     * Constructor
     *
     * @param array $settings Widget settings
     * @param string $widget_name Widget name
     */
    public function __construct($settings = [], $widget_name = '')
    {
        $this->target_widget_settings = $settings;
        $this->target_widget_name = $widget_name;
    }

    /**
     * Render a single product item specifically for the Glossy Grid widget
     *
     * @param WC_Product $product The product object to render
     * @param array $settings The widget settings
     */
    public function render_glossy_grid_item($product, $settings)
    {
        if (!$product) {
            return;
        }
        $product_id = $product->get_id();
        $rating_count = $product->get_rating_count();
        $average = $product->get_average_rating();
        // Get product categories
        $tooltip_position = isset($settings['tooltip_position']) ? $settings['tooltip_position'] : 'right';
        // get the class based on the widget
        $show_rating = isset($settings['show_rating']) ? $settings['show_rating'] : true;
        $classes = $this->target_widget_name === 'glossy-grid' ? 'usk-item' : 'usk-item swiper-slide';
        $classes .= $show_rating ? ' usk-have-rating' : '';
        $title_tags = isset($settings['title_tags']) ? $settings['title_tags'] : 'h3';
        $category_tags = isset($settings['category_tags']) ? $settings['category_tags'] : 'h3';


        ?>
        <div class="<?php echo esc_attr($classes); ?>" data-product-id="<?php echo esc_attr($product_id); ?>">
            <div class="usk-item-box">
                <?php $this->render_product_image($product, $settings); ?>
                <div class="usk-content">
                    <div class="usk-content-inner">
                        <?php if (isset($settings['show_title']) ? $settings['show_title'] : true):
                            printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($title_tags), esc_url($product->get_permalink()), esc_html($product->get_title()));
                        endif; ?>
                        <?php if (isset($settings['show_price']) ? $settings['show_price'] : true && $product->get_price_html()): ?>
                            <div class="usk-price">
                                <?php $this->print_price_output($product->get_price_html()); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($settings['show_rating']) ? $settings['show_rating'] : true): ?>
                            <div class="usk-rating">
                                <?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="usk-shoping">
                    <?php
                    $this->register_global_template_add_to_wishlist($tooltip_position, $settings);
                    $this->register_global_template_add_to_compare($tooltip_position, $settings);
                    $this->register_global_template_quick_view($product->get_id(), $tooltip_position, $settings);
                    $this->register_global_template_add_to_cart($tooltip_position, $settings);

                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    /**
     * Render product image with hover effect and action buttons
     *
     * @param WC_Product $product The product object
     */
    public function render_product_image($product, $settings)
    {
        if (!$product) {
            return;
        }
        $gallery_thumbs = $product->get_gallery_image_ids();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), isset($settings['image_size']) ? $settings['image_size'] : 'full');
        if ($gallery_thumbs) {
            foreach ($gallery_thumbs as $key => $gallery_thumb) {
                if ($key == 0):
                    $gallery_image_link = wp_get_attachment_image_url($gallery_thumb, isset($settings['image_size']) ? $settings['image_size'] : 'full');
                endif;
            }
        } else {
            $gallery_image_link = wp_get_attachment_image_url(get_post_thumbnail_id(), isset($settings['image_size']) ? $settings['image_size'] : 'full');
        }
        ?>
        <div class="usk-image">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>"
                    alt="<?php echo esc_html(get_the_title()); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>"
                    alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content usk-flex usk-flex-column usk-flex-bottom">
                    <?php $this->register_global_template_badge_label($settings); ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function print_price_output($output)
    {
        $tags = [
            'del' => ['aria-hidden' => []],
            'span' => ['class' => []],
            'bdi' => [],
            'ins' => [],
        ];

        if (isset($output)) {
            echo wp_kses($output, $tags);
        }
    }
}
