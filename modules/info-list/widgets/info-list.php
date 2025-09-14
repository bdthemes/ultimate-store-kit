<?php
    
    namespace UltimateStoreKit\Modules\InfoList\Widgets;
    
    use UltimateStoreKit\Base\Module_Base;
    use Elementor\Group_Control_Css_Filter;
    use Elementor\Repeater;
    use Elementor\Controls_Manager;
    use Elementor\Group_Control_Box_Shadow;
    use Elementor\Group_Control_Image_Size;
    use Elementor\Group_Control_Typography;
    use Elementor\Group_Control_Text_Shadow;
    use Elementor\Group_Control_Background;
    use Elementor\Group_Control_Border;
    use Elementor\Icons_Manager;
    use Elementor\Utils;
    
if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly
    
class Info_List extends Module_Base {
        
    public function get_name()
    {
        return 'usk-info-list';
    }
        
    public function get_title()
    {
        return  esc_html__('Info List', 'ultimate-store-kit');
    }
        
    public function get_icon()
    {
        return 'usk-widget-icon usk-icon-info-list';
    }
    
    public function get_categories()
    {
        return ['ultimate-store-kit'];
    }
        
    public function get_keywords()
    {
        return [ 'icon', 'list', 'feature', 'box', 'info' ];
    }
        
    public function get_style_depends()
    {
        if ($this->usk_is_edit_mode()) {
            return [ 'usk-styles' ];
        } else {
            return [ 'usk-info-list' ];
        }
    }
        
    public function get_custom_help_url() {
     return 'https://youtu.be/vVCYUAPuqcg?si=ld1BjZ6KIy3OU62Y';
    }
        
    public function has_widget_inner_wrapper(): bool {
        return ! \Elementor\Plugin::$instance->experiments->is_feature_active( 'e_optimized_markup' );
    }

    protected function is_dynamic_content(): bool {
		return false;
	}

    protected function register_controls() {

        $this->start_controls_section(
            'usk_section_list',
            [
                'label' => __('Items', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
            
        $repeater = new Repeater();

        $repeater->add_control(
            'list_icon',
            [
                'label' => __('Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::ICONS,
                'label_block' => false,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'skin' => 'inline',
            ]
        );
            
        $repeater->add_control(
            'title',
            [
                'label'       => __('Title', 'ultimate-store-kit'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => esc_html__('This is a title', 'ultimate-store-kit'),
                'placeholder' => __('Enter your title', 'ultimate-store-kit'),
                'label_block' => true,
            ]
        );
    
        $repeater->add_control(
            'title_link',
            [
                'label'       => esc_html__('Title Link', 'ultimate-store-kit'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [ 'active' => true ],
                'placeholder' => 'http://your-link.com',
            ]
        );

        $repeater->add_control(
            'text',
            [
                'label'       => esc_html__('Text', 'ultimate-store-kit'),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic'     => ['active' => true],
                'default'     => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'ultimate-store-kit'),
    
            ]
        );

        $repeater->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_repeater_background',
                'selector'  => '{{WRAPPER}} {{CURRENT_ITEM}}.usk-info-list-item',
                'separator' => 'before'
            ]
        );
            
        $this->add_control(
            'info_items',
            [
                'show_label'  => false,
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default' => [
                    [
                        'title' => __('List Item #1', 'ultimate-store-kit'),
                    ],
                    [
                        'title' => __('List Item #2', 'ultimate-store-kit'),
                    ],
                    [
                        'title' => __('List Item #3', 'ultimate-store-kit'),
                    ],
                ],
                'title_field' => '{{{ elementor.helpers.renderIcon( this, list_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ title }}}',
            ]
        );

        $this->end_controls_section();
            
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __('Additional Options', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label'           => __('Columns', 'ultimate-store-kit'),
                'type'            => Controls_Manager::SELECT,
                'default'         => 1,
                'tablet_default'  => 1,
                'mobile_default'  => 1,
                'options'         => [
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
                ],
            ]
        );

        $this->add_responsive_control(
            'column_gap',
            [
                'label'     => esc_html__('Column Gap', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'row_gap',
            [
                'label'     => esc_html__('Row Gap', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label'     => esc_html__('Icon Position', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'top',
                'options'   => [
                    'left' => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'top'   => [
                        'title' => esc_html__('Top', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'toggle' => false
            ]
        );
            
        $this->add_responsive_control(
            'icon_alignment',
            [
                'label'     => esc_html__('Icon Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'   => [
                        'title' => esc_html__('Top', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Bottom', 'ultimate-store-kit'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list .usk-info-list-item' => 'align-items: {{VALUE}}',
                ],
                'condition' => [
                    'icon_position!' => 'top'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'     => esc_html__('Icon Spacing', 'ultimate-store-kit'),
                'type'      => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-item' => 'grid-column-gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .usk-info-style-top .usk-info-list-item' => 'grid-row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Alignment', 'ultimate-store-kit'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'ultimate-store-kit'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-item, {{WRAPPER}} .usk-info-list-content' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label'   => __('Show Title', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
    
        $this->add_control(
            'title_tag',
            [
                'label'   => __('Title HTML Tag', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => ultimate_store_kit_title_tags(),
                'condition' => [
                    'show_title' => 'yes',
                ]
            ]
        );
    
        $this->add_control(
            'show_text',
            [
                'label'   => esc_html__('Show Text', 'ultimate-store-kit'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => __('Items', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_item_style');

        $this->start_controls_tab(
            'tab_item_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_background',
                'selector'  => '{{WRAPPER}} .usk-info-list-item',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'item_border',
                'label'          => esc_html__('Border', 'ultimate-store-kit'),
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => false,
                        ],
                    ],
                    'color'  => [
                        'default' => '#dbdbdb',
                    ],
                ],
                'selector'       => '{{WRAPPER}} .usk-info-list-item',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_box_shadow',
                'selector' => '{{WRAPPER}} .usk-info-list-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'item_hover_background',
                'selector'  => '{{WRAPPER}} .usk-info-list-item:hover',
            ]
        );

        $this->add_control(
            'item_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#2B2D42',
                'condition' => [
                    'item_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-item:hover' => 'border-color: {{VALUE}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_hover_box_shadow',
                'selector' => '{{WRAPPER}} .usk-info-list-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-title a' => 'color: {{VALUE}} ',
                ],
            ]
        );
    
        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Hover Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-title a:hover' => 'color: {{VALUE}} ',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .usk-info-list-title',
            ]
        );
    
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_text',
            [
                'label' => __('Text', 'ultimate-store-kit'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
    
        $this->add_control(
            'text_color',
            [
                'label'     => __('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .usk-info-list-text',
            ]
        );
    
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_icon',
            [
                'label'     => esc_html__('Icon', 'ultimate-store-kit'),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_icon_style');
            
        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => esc_html__('Normal', 'ultimate-store-kit'),
            ]
        );
            
        $this->add_control(
            'icon_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-icon span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-info-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
            
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_background',
                'selector' => '{{WRAPPER}} .usk-info-list-icon span',
            ]
        );
            
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'icon_border',
                'selector' => '{{WRAPPER}} .usk-info-list-icon span',
            ]
        );
            
        $this->add_responsive_control(
            'icon_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
            
        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => esc_html__('Padding', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
            
        $this->add_responsive_control(
            'icon_margin',
            [
                'label'      => esc_html__('Margin', 'ultimate-store-kit'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .usk-info-list-icon span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
            
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'icon_shadow',
                'selector' => '{{WRAPPER}} .usk-info-list-icon span',
            ]
        );
            
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'icon_typography',
                'label'    => esc_html__('Typography', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-info-list-icon span',
            ]
        );
            
        $this->end_controls_tab();
            
        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => esc_html__('Hover', 'ultimate-store-kit'),
            ]
        );
            
        $this->add_control(
            'icon_hover_color',
            [
                'label'     => esc_html__('Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-icon span:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-info-list-icon span:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
            
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'icon_hover_background',
                'selector' => '{{WRAPPER}} .usk-info-list-icon span:hover',
            ]
        );
            
        $this->add_control(
            'icon_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'icon_border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-info-list-icon span:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );
            
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    public function render_title($item)
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_title']) {
            return;
        }

        if ( !empty($item['title']) && !empty($item['title_link']['url']) ) {
            $this->add_link_attributes('title-link', $item['title_link'], true);
        }

        if (!empty($item['title'])) {
            printf('<%1$s class="usk-info-list-title"><a %2$s title="%3$s">%3$s</a></%1$s>', esc_attr($settings['title_tag']), wp_kses_post($this->get_render_attribute_string('title-link')), wp_kses_post($item['title']));
        }
    }

    public function render_text($item)
    {
        $settings = $this->get_settings_for_display();

        if (! $settings['show_text']) {
            return;
        }

        ?>
        <?php if ($item['text']) : ?>
            <div class="usk-info-list-text">
                <?php echo wp_kses_post($item['text']); ?>
            </div>
        <?php endif;
    }
        
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        if (empty($settings['info_items'])) {
            return;
        }
        
        $this->add_render_attribute('info-list', 'class', 'usk-info-list usk-info-style-' . $settings['icon_position']);

        ?>
        <div <?php $this->print_render_attribute_string('info-list'); ?>>
        <?php foreach ($settings['info_items'] as $item) :

            $this->add_render_attribute('item-wrap', 'class', 'usk-info-list-item elementor-repeater-item-' . esc_attr($item['_id']), true);
    
            ?>
            <div <?php $this->print_render_attribute_string('item-wrap'); ?>>

                <?php if (!empty($item['list_icon']['value'])) : ?>
                    <div class="usk-info-list-icon">
                        <span>
                            <?php Icons_Manager::render_icon($item['list_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    </div>
                <?php endif; ?>
                <div class="usk-info-list-content">
                    <?php $this->render_title($item); ?>
                    <?php $this->render_text($item); ?>
                </div>

            </div>

        <?php endforeach; ?>
        </div>
        <?php
    }
}
