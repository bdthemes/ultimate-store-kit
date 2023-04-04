<?php

use Elementor\TemplateLibrary\Source_Local;

class Ultimate_Store_Kit_Activator {

    public static function activate() {
        return true;
        // $slug = ultimate_store_kit_compare_product_slug();
        // $page = get_page_by_path($slug);

        // $response = '{"content":[{"id":"1eecdd6d","settings":[],"elements":[{"id":"142882c1","settings":{"_column_size":100,"_inline_size":null},"elements":[{"id":"2da2ac3a","settings":[],"elements":[],"isInner":false,"widgetType":"usk-compare-products","elType":"widget"}],"isInner":false,"elType":"column"}],"isInner":false,"elType":"section"}],"page_settings":[],"version":"0.4","title":"Compare page","type":"section"}';
        // $page_data = array(
        //     'post_status'   => 'publish',
        //     'post_type'     => 'page',
        //     'post_author'   => 1,
        //     'post_name'     => $slug,
        //     'post_title'    => 'Compare Products',
        // 'post_content'  => $response,
        //     'comment_status'    => 'closed',
        // );

        // if (isset($page->ID) && is_integer($page->ID)) {
        //     wp_update_post($page_data);
        // } else {
        //     wp_insert_post($page_data);
        // }
    }
}
