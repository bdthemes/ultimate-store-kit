<?php

namespace UltimateStoreKit\Modules\FlorenceCarousel\Widgets;

use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\Templates\USK_Florence_Grid_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Florence_Carousel extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;


    public function get_name() {
        return 'usk-florence-carousel';
    }

    public function get_title() {
        return esc_html__('Florence Carousel', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-florence-carousel';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'product-carousel', 'table', 'wc'];
    }

    public function get_script_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'micromodal', 'usk-site'];
        } else {
            return ['swiper', 'micromodal', 'usk-florence-carousel'];
        }
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['swiper', 'usk-all-styles'];
        } else {
            return ['swiper', 'usk-font', 'usk-florence-carousel'];
        }
    }

    public function get_custom_help_url() {
        return 'https://youtu.be/eqAsEwqcKdM';
    }

    public function get_query() {
        return $this->_query;
    }
    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }
    protected function register_controls() {

        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 3,
                'tablet_default' => 2,
                'mobile_default' => 1,
                'options' => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ],
            ]
        );
        $this->add_responsive_control(
            'items_gap',
            [
                'label' => esc_html__('Item Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'tablet_default' => [
                    'size' => 20,
                ],
                'mobile_default' => [
                    'size' => 20,
                ],
            ]
        );

        $this->register_global_controls_grid_layout();

        $this->end_controls_section();
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->register_controls_wc_additional();
        $this->end_controls_section();
        $this->register_global_controls_additional();
        $this->register_global_controls_carousel_navigation();
        $this->register_global_controls_carousel_settings();
        $this->register_global_controls_grid_items();
        $this->register_global_controls_grid_image();
        $this->register_global_controls_content();
        $this->register_global_controls_title();
        $this->register_global_controls_category();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();
        $this->register_global_controls_navigation_style();
    }

    public function render_loop_item() {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();

        if ($wp_query->have_posts()) :
            while ($wp_query->have_posts()) : $wp_query->the_post();
                global $product;
                $florence_grid_template = new USK_Florence_Grid_Template($settings, 'florence-carousel');
                $florence_grid_template->render_florence_grid_item($product, $settings);
            endwhile;
            wp_reset_postdata();
        else :
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        endif;
    }
    public function render() {
        $this->register_global_template_carousel_header();
        $this->render_loop_item();
        $this->usk_register_global_template_carousel_footer();
    }
    public function query_product() {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
}
