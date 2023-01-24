<?php

namespace UltimateStoreKit\Modules\AdditionalInformation\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use UltimateStoreKit\Base\Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// class Add_To_Cart extends Widget_Button {
class Additional_Information extends Module_Base {

    public function get_show_in_panel_tags() {
        return ['shop_single'];
    }

    public function get_name() {
        return 'usk-additional-information';
    }

    public function get_title() {
        return BDTUSK . esc_html__('Additional Information', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-additional-information usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit-single'];
    }

    public function get_keywords() {
        return ['add', 'to', 'cart', 'woocommerce', 'wc', 'additional', 'info'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['ultimate-store-kit-font', 'usk-add-to-cart'];
        }
    }

    protected function register_controls() {

        $this->start_controls_section(
            'section_additional_information',
            array(
                'label' => esc_html__('layout', 'utlimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );


        $this->add_responsive_control(
            'additional_information_table_cell_padding',
            [
                'label'      => esc_html__('Cell Padding', 'utlimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .usk-additional-information tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .usk-additional-information tr td' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}}; text-align:right;',
                    '{{WRAPPER}} .usk-additional-information tr th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '.rtl {{WRAPPER}} .usk-additional-information tr th' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};text-align:right;',
                ],
            ]
        );

        $this->add_control(
            'additional_information_separator_color',
            [
                'label'     => esc_html__('Separator Color', 'utlimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-additional-information .shop_attributes tr:not(:last-child),
					{{WRAPPER}} .usk-additional-information table.shop_attributes tr td,
					{{WRAPPER}} .usk-additional-information table.shop_attributes tr th' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_additional_information_label',
            [
                'label' => esc_html__('Label', 'utlimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'additional_information_label_color',
            [
                'label'     => esc_html__('Color', 'utlimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-additional-information tr th' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'additional_information_label_bg_color',
            [
                'label'     => esc_html__('Background', 'utlimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-additional-information tr th' => 'background: {{VALUE}};',
                ],
            ]
        );



        $this->add_responsive_control(
            'additional_information_label_width',
            [
                'label'      => esc_html__('Width', 'utlimate-store-kit'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 5,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 25,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-additional-information tr th' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'additional_information_label_typography',
                'label'          => esc_html__('Typography', 'utlimate-store-kit'),
                'selector'       => '{{WRAPPER}} .usk-additional-information tr :is(td, th, p) ',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_information_value',
            array(
                'label' => esc_html__('Value', 'utlimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'additional_information_value_color',
            [
                'label'     => esc_html__('Color', 'utlimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-additional-information tr td p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'additional_information_value_bg_color',
            [
                'label'     => esc_html__('Background', 'utlimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-additional-information tr td' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'additional_information_value_typography',
                'label'          => esc_html__('Typography', 'utlimate-store-kit'),
                'selector'       => '{{WRAPPER}} .usk-additional-information tr :is(td, th, p) ',
            ]
        );


        $this->end_controls_section();
    }

    public function render() {
        $this->usk_set_single_post_preview_data();
        $product = wc_get_product();

        if (empty($product)) {
            return;
        }
?>
        <div class="usk-additional-information">
            <?php wc_get_template('single-product/tabs/additional-information.php'); ?>
        </div>
<?php

    }
}
