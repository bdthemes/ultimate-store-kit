<?php

namespace UltimateStoreKit\Modules\PageSingle\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Page_Single extends Module_Base {

    // public function get_show_in_panel_tags() {
    //     return ['shop_single'];
    // }

    public function get_name() {
        return 'usk-page-single';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Single Product (Page)', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-page-single usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'additional', 'info'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-page-single'];
        }
    }
    public function render() { ?>
        <div class="usk-page-sinigle">
            <?php echo do_shortcode('[product_page id="' . get_the_ID() . '"]'); ?>
        </div>
<?php }
}
