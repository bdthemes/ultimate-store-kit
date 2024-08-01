<?php

namespace UltimateStoreKit\Modules\PageMyAccount\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Page_My_Account extends Module_Base {

    public function get_show_in_panel_tags() {
        return ['shop_single'];
    }

    public function get_name() {
        return 'usk-page-my-account';
    }

    public function get_title() {
        return BDTUSK . esc_html__('My Account (Page)', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-page-my-account usk-new';
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
            return ['usk-font', 'usk-page-my-account'];
        }
    }
    protected function register_controls() {
        // $this->register_controls_account_navigation();
        //$this->register_account_dashboard();
    }
    protected function register_controls_account_navigation() {
        $this->start_controls_section(
            'account_navigation',
            [
                'label' => esc_html__('Navigation', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navigation_padding',
            [
                'label'                 => esc_html__('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-account-navigation ul'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'item_border',
                'label'     => esc_html__('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-navigation ul',
            ]
        );
        $this->add_control(
            'navigation_radius',
            [
                'label'                 => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-account-navigation ul'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'navigation_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-navigation ul li',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'account_navigation_list',
            [
                'label' => esc_html__('Navigation List', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'navigation_list_style_type',
            [
                'label'      => esc_html__('Style', 'ultimate-store-kit'),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'circle',
                'options'    => [
                    'none'   => esc_html__('None', 'ultimate-store-kit'),
                    'square'  => esc_html__('Square', 'ultimate-store-kit'),
                    'circle' => esc_html__('Circle', 'ultimate-store-kit'),
                    'decimal' => esc_html__('Decimal', 'ultimate-store-kit'),
                    'disc' => esc_html__('Bullet', 'ultimate-store-kit'),
                    'lower-alpha' => esc_html__('Lower Alpha', 'ultimate-store-kit'),
                    'upper-alpha' => esc_html__('Upper Alpha', 'ultimate-store-kit'),
                    'lower-roman' => esc_html__('Lower Roman', 'ultimate-store-kit'),
                    'upper-roman' => esc_html__('Upper Roman', 'ultimate-store-kit'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li' => 'list-style-type:{{VALUE}};'
                ]
            ]
        );
        $this->add_control(
            'navigation_list_color',
            [
                'label'     => esc_html__('Color', 'Color'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li' => 'color:{{VALUE}};'
                ],
                'condition' => [
                    'navigation_list_style_type!' => 'none'
                ]
            ]
        );
        $this->add_responsive_control(
            'navigation_list_padding',
            [
                'label'                 => __('Padding', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-account-navigation ul li'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'navigation_list_margin',
            [
                'label'                 => __('Margin', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-account-navigation ul li'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'navigation_border',
                'label'     => __('Border', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-navigation ul li',
            ]
        );
        $this->add_responsive_control(
            'navigation_list_radius',
            [
                'label'                 => __('Border Radius', 'ultimate-store-kit'),
                'type'                  => Controls_Manager::DIMENSIONS,
                'size_units'            => ['px', '%', 'em'],
                'selectors'             => [
                    '{{WRAPPER}} .usk-account-navigation ul li'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'navigation_bottom-spacing',
            [
                'label'         => esc_html__('Bottom Spacing', 'ultimate-store-kit'),
                'type'          => Controls_Manager::SLIDER,
                'size_units'    => ['px'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                        'step'  => 1,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul' => 'grid-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->start_controls_tabs(
            'navigation_tab'
        );
        $this->start_controls_tab(
            'tabs_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'normal_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'normal_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_active',
            [
                'label' => esc_html__('Active', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'active_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li.is-active a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'active_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li.is-active' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'active_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li.is-active' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation_border_border!' => 'yes'
                ]
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li:hover a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_background',
            [
                'label'     => esc_html__('Background', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li:hover' => 'background: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-navigation ul li:hover' => 'border-color: {{VALUE}}',
                ],
                'condition' => [
                    'navigation_border_border!' => 'yes'
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    protected function register_account_dashboard() {
        $this->start_controls_section(
            'style_section_dashboard',
            [
                'label' => __('Dashboard', 'ultimate-store-kit'),
            ]
        );
        $this->start_controls_tabs(
            'dashboard_tabs'
        );
        $this->start_controls_tab(
            'tabs_text',
            [
                'label' => esc_html__('Text', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-dashboard  p' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'text_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-dashboard p',
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_user',
            [
                'label' => esc_html__('User', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'user_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-dashboard  p strong' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'user_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-dashboard p strong',
                'exclude' => ['line_height', 'text_decoration']
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tabs_link',
            [
                'label' => esc_html__('Link', 'ultimate-store-kit'),
            ]
        );
        $this->add_control(
            'link_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-account-dashboard  p a' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'link_typography',
                'label'     => esc_html__('Typography', 'ultimate-store-kit'),
                'selector'  => '{{WRAPPER}} .usk-account-dashboard p a',
                'exclude' => ['line_height', 'text_transform']
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }


    protected function render() {
        if (!is_user_logged_in()) {
            esc_html_e('You need logged in first', 'ultimate-store-kit');
        } else { ?>
            <div class="usk-page-my-account">
                <?php echo do_shortcode('[woocommerce_my_account]'); ?>
            </div>
<?php
        }
    }
}
