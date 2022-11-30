<?php

namespace UltimateStoreKit\Modules\ProductImage\Widgets;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Product_Image extends Module_Base {

    public function get_name() {
        return 'usk-product-image';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Product Image', 'ultimate-store-kit-pro');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-product-image usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['account', 'my-account', 'address'];
    }

//    public function get_style_depends() {
//        if ($this->usk_is_edit_mode()) {
//            return ['usk-all-styles'];
//        } else {
//            return ['usk-product-image'];
//        }
//    }


    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles-pro'];
        } else {
            return ['usk-product-image'];
        }
    }



    // public function get_custom_help_url() {
    //     return 'https://youtu.be/ksy2uZ5Hg3M';
    // }

    protected function render() {

        if($this->usk_is_edit_mode()){
            $this->load_assets_dependencies();
        }

        $this->usk_set_single_post_type_editor_builder_data();

        woocommerce_show_product_images();

        // On render widget from Editor - trigger the init manually.
        if ( $this->usk_is_edit_mode() ) {
            ?>
            <script>
                jQuery( '.woocommerce-product-gallery' ).each( function() {
                    jQuery( this ).wc_product_gallery();
                } );
            </script>
            <?php
        }
    }

    private function load_assets_dependencies() {
        if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
            wp_enqueue_script( 'zoom' );
        }
        if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
            wp_enqueue_script( 'flexslider' );
        }
        if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
            wp_enqueue_script( 'photoswipe-ui-default' );
            wp_enqueue_style( 'photoswipe-default-skin' );
            add_action( 'wp_footer', 'woocommerce_photoswipe' );
        }
        wp_enqueue_script( 'wc-single-product' );

        wp_enqueue_style( 'photoswipe' );
        wp_enqueue_style( 'photoswipe-default-skin' );
        wp_enqueue_style( 'woocommerce_prettyPhoto_css' );
    }
}
