<?php

namespace UltimateStoreKit\Modules\BrandCarousel\Widgets;

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
use Elementor\Utils;

use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;

if (! defined('ABSPATH')) {
	exit;
} // Exit if accessed directly

class Brand_Carousel extends Module_Base {
	use Global_Widget_Controls;
	use Global_Widget_Template;

	public function get_name() {
		return 'usk-brand-carousel';
	}

	public function get_title() {
		return esc_html__('Brand Carousel', 'ultimate-store-kit');
	}

	public function get_icon() {
		return 'usk-widget-icon usk-icon-brand-carousel';
	}

	public function get_categories() {
		return ['ultimate-store-kit'];
	}

	public function get_keywords() {
		return ['brand', 'carousel', 'client', 'logo', 'showcase'];
	}

	public function get_style_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['swiper', 'usk-styles'];
		} else {
			return ['swiper', 'usk-font', 'usk-brand-carousel'];
		}
	}

	public function get_script_depends() {
		if ($this->usk_is_edit_mode()) {
			return ['swiper', 'usk-site'];
		} else {
			return ['swiper', 'usk-brand-carousel'];
		}
	}

	public function has_widget_inner_wrapper(): bool {
		return ! \Elementor\Plugin::$instance->experiments->is_feature_active('e_optimized_markup');
	}

	protected function is_dynamic_content(): bool {
		return false;
	}
	
	protected function register_controls() {

		$this->start_controls_section(
			'usk_section_brands',
			[
				'label' => __('Brand Items', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label'   => __('Brand Image', 'ultimate-store-kit'),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'brand_name',
			[
				'label'       => __('Brand Name', 'ultimate-store-kit'),
				'type'        => Controls_Manager::TEXT,
				'default'     => __('Brand Name', 'ultimate-store-kit'),
				'label_block' => true,
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'         => __('Url', 'ultimate-store-kit'),
				'type'          => Controls_Manager::URL,
				'placeholder'   => __('https://your-link.com', 'ultimate-store-kit'),
				'show_external' => true,
				'default'      => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => true,
				],
				'label_block'   => true,
				'dynamic'       => ['active'      => true],
			]
		);

		$this->add_control(
			'brand_items',
			[
				'show_label'  => false,
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ name }}}',
				'default'     => [
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
					['image' => ['url' => Utils::get_placeholder_image_src()]],
				]
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

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				'default'   => 'medium',
				'separator' => 'before',
				'exclude'   => ['custom']
			]
		);

		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__('Alignment', 'ultimate-store-kit'),
				'type' => Controls_Manager::HIDDEN,
			]
		);

		$this->end_controls_section();

		$this->register_global_controls_carousel_navigation();
		$this->register_global_controls_carousel_settings();

		//Style
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
				'selector'  => '{{WRAPPER}} .usk-brand-carousel-item',
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
				'selector'       => '{{WRAPPER}} .usk-brand-carousel-item',
				'separator'   => 'before',
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-brand-carousel-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => esc_html__('Padding', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-brand-carousel-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_box_shadow',
				'selector' => '{{WRAPPER}} .usk-brand-carousel-item',
			]
		);

		$this->add_control(
			'carousel_shadow_mode',
			[
				'label'        => esc_html__('Shadow Mode', 'ultimate-store-kit'),
				'type'         => Controls_Manager::SWITCHER,
				'prefix_class' => 'usk-shadow-mode-',
				'render_type' => 'template',
				'separator' => 'before'
			]
		);

		$this->add_control(
			'carousel_shadow_color',
			[
				'label'     => esc_html__('Shadow Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'carousel_shadow_mode' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}}.usk-shadow-mode-yes:before' => is_rtl() ? 'background: linear-gradient(to left, {{VALUE}} 5%,rgba(255,255,255,0) 100%);' : 'background: linear-gradient(to right, {{VALUE}} 5%,rgba(255,255,255,0) 100%);',
					'{{WRAPPER}}.usk-shadow-mode-yes:after'  => is_rtl() ? 'background: linear-gradient(to left, rgba(255,255,255,0) 0%, {{VALUE}} 95%);' : 'background: linear-gradient(to right, rgba(255,255,255,0) 0%, {{VALUE}} 95%);',
				],
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
				'selector'  => '{{WRAPPER}} .usk-brand-carousel-item:hover',
			]
		);

		$this->add_control(
			'item_hover_border_color',
			[
				'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'default' 	=> '#2B2D42',
				'condition' => [
					'item_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-item:hover' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'item_hover_box_shadow',
				'selector' => '{{WRAPPER}} .usk-brand-carousel-item:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => __('Image', 'ultimate-store-kit'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs('tabs_image_style');

		$this->start_controls_tab(
			'tab_image_normal',
			[
				'label' => esc_html__('Normal', 'ultimate-store-kit'),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'image_border',
				'selector'       => '{{WRAPPER}} .usk-brand-carousel-img',
			]
		);

		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__('Border Radius', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-brand-carousel-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'image_padding',
			[
				'label'      => esc_html__('Padding', 'ultimate-store-kit'),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .usk-brand-carousel-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'brand_image_height',
			[
				'label' => __('Height', 'ultimate-store-kit'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'brand_image_width',
			[
				'label' => __('Width', 'ultimate-store-kit'),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'brand_image_opaciry',
			[
				'label' => __('Opaciry', 'ultimate-store-kit'),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.3,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters',
				'selector' => '{{WRAPPER}} .usk-brand-carousel-img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_image_hover',
			[
				'label' => esc_html__('Hover', 'ultimate-store-kit'),
			]
		);

		$this->add_control(
			'image_hover_border_color',
			[
				'label'     => esc_html__('Border Color', 'ultimate-store-kit'),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'image_border_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-item:hover .usk-brand-carousel-img' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'brand_image_opaciry_hover',
			[
				'label' => __('Opaciry', 'ultimate-store-kit'),
				'type'  => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .usk-brand-carousel-item:hover .usk-brand-carousel-img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'css_filters_hover',
				'selector' => '{{WRAPPER}} .usk-brand-carousel-item:hover .usk-brand-carousel-img',
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->register_global_controls_navigation_style();
	}

	public function render_loop_item() {
		$settings = $this->get_settings_for_display();

		if (empty($settings['brand_items'])) {
			return;
		}

?>
		<?php foreach ($settings['brand_items'] as $item) :

			$thumb_url = Group_Control_Image_Size::get_attachment_image_src($item['image']['id'], 'thumbnail', $settings);
			if (!$thumb_url) {
				$thumb_url = $item['image']['url'];
			}

			if (!empty($item['link']['url'])) {
				$this->add_link_attributes('link', $item['link'], true);
			}

			$this->add_render_attribute('item-wrap', 'class', 'usk-brand-carousel-item usk-flex usk-flex-middle usk-flex-center', true);

		?>
			<div class="swiper-slide">
				<div <?php $this->print_render_attribute_string('item-wrap'); ?> title="<?php echo esc_html($item['brand_name']); ?>">
					<img class="usk-brand-carousel-img" src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_html($item['brand_name']); ?>">
					<?php
					if (!empty($item['link']['url'])) {
						printf('<a %1$s title="%2$s"></a>', wp_kses_post($this->get_render_attribute_string('link')), wp_kses_post($item['brand_name']));
					} ?>
				</div>
			</div>

		<?php endforeach; ?>
		<!-- </div> -->
<?php
	}

	public function render() {
		$this->register_global_template_carousel_header();
		$this->render_loop_item();
		$this->usk_register_global_template_carousel_footer();
	}
}
