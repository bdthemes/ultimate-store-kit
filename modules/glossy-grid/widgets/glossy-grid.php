<?php

namespace UltimateStoreKit\Modules\GlossyGrid\Widgets;

use Elementor\Controls_Manager;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\Traits\Global_Widget_Controls;
use UltimateStoreKit\Traits\Global_Widget_Template;
use UltimateStoreKit\Templates\USK_Glossy_Grid_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Glossy_Grid extends Module_Base
{
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;
    // use Global_Widget_Template;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name()
    {
        return 'usk-glossy-grid';
    }

    public function get_title()
    {
        return esc_html__('Glossy Grid', 'ultimate-store-kit');
    }

    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-glossy-grid';
    }

    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }

    public function get_keywords()
    {
        return ['product', 'product-grid', 'table', 'wc'];
    }

    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-glossy-grid'];
        }
    }

    public function get_script_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return ['micromodal', 'usk-site'];
        } else {
            return ['micromodal', 'usk-shiny-grid'];
        }
    }

    public function get_custom_help_url()
    {
        return 'https://youtu.be/H-EwEpbeXFA';
    }

    public function get_query()
    {
        return $this->_query;
    }
    public function has_widget_inner_wrapper(): bool
    {
        return !\Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
    }
    protected function register_controls()
    {

        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label' => esc_html__('Style', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'ultimate-store-kit'),
                    'list' => esc_html__('List', 'ultimate-store-kit'),
                ],
                'condition' => [
                    'show_tab!' => 'yes'
                ]
            ]
        );
        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'condition' => [
                    'layout_style' => 'grid',
                    'show_tab!' => 'yes'
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-grid .usk-grid.usk-grid-layout' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',

                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'columns_list',
            [
                'label' => esc_html__('Columns', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => '2',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'condition' => [
                    'layout_style' => 'list'
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-grid .usk-grid.usk-list-layout' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',

                ],
                'render_type' => 'template'
            ]
        );

        $this->add_responsive_control(
            'items_columns_gap',
            [
                'label' => esc_html__('Columns Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-grid .usk-grid' => 'grid-column-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'items_row_gap',
            [
                'label' => esc_html__('Row Gap', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-glossy-grid .usk-grid' => 'grid-row-gap: {{SIZE}}px;',
                ],
            ]
        );

        $this->register_global_controls_grid_layout();

        $this->add_control(
            'show_tab',
            [
                'label' => esc_html__('Columns Filter', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'condition' => [
                    'layout_style' => 'grid'
                ]
            ]
        );
        $this->add_control(
            'filter_column_lists',
            [
                'label' => __('Select Column Type', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT2,
                'label_block' => true,
                'multiple' => true,
                'options' => [
                    'list-2' => __('List view', 'ultimate-store-kit'),
                    'grid-2' => __('Column 2', 'ultimate-store-kit'),
                    'grid-3' => __('Column 3', 'ultimate-store-kit'),
                    'grid-4' => __('Column 4', 'ultimate-store-kit'),
                    'grid-5' => __('Column 5', 'ultimate-store-kit'),
                    'grid-6' => __('Column 6', 'ultimate-store-kit'),

                ],
                'condition' => [
                    'show_tab' => 'yes',
                    'layout_style' => 'grid'
                ],
                'default' => ['list-2', 'grid-2', 'grid-3', 'grid-4'],
            ]
        );
        $this->add_control(
            'show_result_count',
            [
                'label' => esc_html__('Result Count', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'ultimate-store-kit'),
                'label_off' => esc_html__('Hide', 'ultimate-store-kit'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_tab' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Pagination', 'ultimate-store-kit'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before'
            ]
        );

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
        $this->register_global_controls_grid_columns();
        $this->register_global_controls_result_count();
        $this->register_global_controls_grid_items();
        $this->register_global_controls_content();
        $this->register_global_controls_grid_image();
        $this->register_global_controls_title();
        $this->register_global_controls_price();
        $this->register_global_controls_rating();
        $this->register_global_controls_badge();
        $this->register_global_controls_action_btn();
        $this->register_global_controls_grid_pagination();
    }

    public function render_header()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute(
            'usk-glossy-grid',
            [
                'class' => [
                    'usk-glossy-grid',
                    'usk-css-grid',
                    'usk-grid-carousel',
                    'usk-content-position-' . $settings['alignment'] . ''
                ],
                'data-filter' => [
                    $settings['show_tab']
                ]
            ]
        );
        ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('usk-glossy-grid'); ?>>
                <?php $this->template_grid_columns(); ?>
                <?php
    }
    public function render_footer()
    {
        ?>
            </div>
        </div>
        <?php
    }
    public function render_loop_item()
    {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();
        if ($settings['layout_style'] === 'grid') {
            $this->add_render_attribute('usk-grid', 'class', ['usk-grid', 'usk-grid-layout']);
        } else {
            $this->add_render_attribute('usk-grid', 'class', ['usk-grid', 'usk-list-layout']);
        }
        if ($wp_query->have_posts()): ?>
            <div <?php $this->print_render_attribute_string('usk-grid'); ?>>
                <?php while ($wp_query->have_posts()):
                    $wp_query->the_post();
                    global $product;
                    $template = new USK_Glossy_Grid_Template($settings, 'glossy-grid');
                    $template->render_glossy_grid_item($product, $settings); ?>
                <?php endwhile; ?>
            </div>
            <?php

            if ($settings['show_pagination']):
                ultimate_store_kit_post_pagination($wp_query);
            endif;
            wp_reset_postdata();
        else:
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        endif;
    }

    public function render()
    {
        $this->render_header();
        $this->render_loop_item();
        $this->render_footer();
    }
    public function query_product()
    {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
    protected function template_grid_columns()
    {
        $settings = $this->get_settings_for_display();
        $this->query_product();
        $wp_query = $this->get_query();
        if (get_query_var('paged')) {
            $paged = get_query_var('paged');
        } elseif (get_query_var('page')) {
            $paged = get_query_var('page');
        } else {
            $paged = 1;
        }
        $args = array(
            'total' => $wp_query->found_posts,
            'per_page' => $settings['product_limit'],
            'current' => $paged,
            'orderedby' => $wp_query->get('orderby'),
        );
        if ($settings['show_tab'] == 'yes'): ?>
            <div class="usk-grid-header usk-visible@l">
                <?php if (($settings['show_result_count'] == 'yes')):
                    wc_get_template('loop/result-count.php', $args);
                endif;
                ?>
                <?php $this->register_templates_grid_columns_markup($settings); ?>
            </div>
        <?php endif;
    }
}
