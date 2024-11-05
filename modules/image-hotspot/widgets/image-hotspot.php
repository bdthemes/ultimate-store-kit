<?php

namespace UltimateStoreKit\Modules\ImageHotspot\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use UltimateStoreKit\Base\Module_Base;
use UltimateStoreKit\Includes\Controls\GroupQuery\Group_Control_Query;
use UltimateStoreKit\traits\Global_Widget_Controls;
use UltimateStoreKit\traits\Global_Widget_Template;
use WP_Query;

if (!defined('ABSPATH')) {
    exit;
}

// Exit if accessed directly

class Image_Hotspot extends Module_Base {
    use Global_Widget_Controls;
    use Global_Widget_Template;
    use Group_Control_Query;

    /**
     * @var \WP_Query
     */
    private $_query = null;
    public function get_name() {
        return 'usk-image-hotspot';
    }

    public function get_title() {
        return esc_html__('Image Hotspot', 'ultimate-store-kit');
    }

    public function get_icon() {
        return 'usk-widget-icon usk-icon-image-hotspot usk-new';
    }

    public function get_categories() {
        return ['ultimate-store-kit'];
    }

    public function get_keywords() {
        return ['product', 'image hotspot', 'hotspot', 'wc', 'carousel', 'slider'];
    }

    public function get_style_depends() {
        if ($this->usk_is_edit_mode()) {
            return ['usk-all-styles'];
        } else {
            return ['usk-font', 'usk-image-hotspot', 'tippy'];
        }
    }

    public function get_script_depends() {
        return ['micromodal', 'popper', 'tippyjs',];
    }

    // public function get_custom_help_url() {
    //     return 'https://youtu.be/3VkvEpVaNAM';
    // }
    public function get_query() {
        return $this->_query;
    }
    protected function register_controls() {
        $this->start_controls_section(
            'section_woocommerce_layout',
            [
                'label' => esc_html__('Image Hotspot', 'ultimate-store-kit'),
            ]
        );

        $this->add_control(
            'image_hotspot_layout',
            [
                'label' => esc_html__('Layout', 'ultimate-store-kit'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'slider' => esc_html__('Slider', 'ultimate-store-kit'),
                    'tooltip' => esc_html__('Tooltip', 'ultimate-store-kit'),
                ],
            ]
        );

        $this->add_control(
            'hotspot_image',
            [
                'label'   => __('Image', 'ultimate-store-kit'),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'hotspot_type',
            [
                'label' => __('Hotspot Type', 'ultimate-store-kit'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'image',
                'options' => [
                    'image' => [
                        'title' => __('Image', 'ultimate-store-kit'),
                        'icon' => 'eicon-image',
                    ],
                    'icon' => [
                        'title' => __('Icon', 'ultimate-store-kit'),
                        'icon' => 'eicon-plus',
                    ],
                ],
                'toggle' => false,
            ]
        );
        $this->add_control(
            'hotspot_icon',
            [
                'label' => __('Icon', 'ultimate-store-kit'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
                'skin' => 'inline',
                'label_block' => false,
            ]
        );
        
        $this->end_controls_section();

        //Query
        $this->start_controls_section(
            'section_post_query_builder',
            [
                'label' => __('Query', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->register_query_builder_controls();
        $this->update_control(
            'product_limit',
            [
                'default' => 3,
            ]
        );
        $this->end_controls_section();

        $this->register_global_controls_additional();

        $this->start_controls_section(
			'section_marker_image',
			[ 
				'label' => __( 'Hotspot Settings', 'bdthemes-prime-slider' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_responsive_control(
			'marker_x_position',
			[ 
				'label'     => esc_html__( 'X Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}}.usk-thumbs-item' => 'left: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_responsive_control(
			'marker_y_position',
			[ 
				'label'     => esc_html__( 'Y Postion', 'bdthemes-prime-slider' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [ 
					'%' => [ 
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [ 
					'{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}}.usk-thumbs-item' => 'top: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'advanced_option_toggle',
			[ 
				'label'        => __( 'Hotspot Style', 'bdthemes-prime-slider' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( 'None', 'bdthemes-prime-slider' ),
				'label_on'     => __( 'Custom', 'bdthemes-prime-slider' ),
				'return_value' => 'yes',
			]
		);

		$repeater->start_popover();

		$repeater->add_control(
			'repeater_marker_color',
			[ 
				'label'       => esc_html__( 'Color', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => [ 
					'{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box svg' => 'fill: {{VALUE}};',
				],
				'render_type' => 'ui',
				'condition'   => [ 
					'advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[ 
				'name'        => 'repeater_marker_background',
				'selector'    => '{{WRAPPER}} .usk-image-hotspot-thumbs {{CURRENT_ITEM}} .usk-thumbs-box',
				'render_type' => 'ui',
				'condition'   => [ 
					'advanced_option_toggle' => 'yes',
				],
			]
		);

		$repeater->end_popover();

		$this->add_control(
			'markers',
			[ 
				'label'       => esc_html__( 'Hotspot Items', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [ 
					[ 
						'marker_x_position' => [ 
							'size' => 50,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 75,
							'unit' => '%',
						],
					],
					[ 
						'marker_x_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 30,
							'unit' => '%',
						],
					],
					[ 
						'marker_x_position' => [ 
							'size' => 65,
							'unit' => '%',
						],
						'marker_y_position' => [ 
							'size' => 20,
							'unit' => '%',
						],
					],
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_tooltip_settings',
			[ 
				'label' => __( 'Tooltip Settings', 'bdthemes-prime-slider' ),
                'condition' => [ 
                    'image_hotspot_layout' => 'tooltip',
                ],
			]
		);

		$this->add_control(
			'marker_tooltip_animation',
			[ 
				'label'       => esc_html__( 'Animation', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'shift-toward',
				'options'     => [ 
					'shift-away'   => esc_html__( 'Shift-Away', 'bdthemes-prime-slider' ),
					'shift-toward' => esc_html__( 'Shift-Toward', 'bdthemes-prime-slider' ),
					'fade'         => esc_html__( 'Fade', 'bdthemes-prime-slider' ),
					'scale'        => esc_html__( 'Scale', 'bdthemes-prime-slider' ),
					'perspective'  => esc_html__( 'Perspective', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);
        $this->add_control(
			'marker_tooltip_placement',
			[ 
				'label'       => esc_html__( 'Placement', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'top',
				'options'     => [ 
					'top-start'    => esc_html__( 'Top Left', 'bdthemes-prime-slider' ),
					'top'          => esc_html__( 'Top', 'bdthemes-prime-slider' ),
					'top-end'      => esc_html__( 'Top Right', 'bdthemes-prime-slider' ),
					'bottom-start' => esc_html__( 'Bottom Left', 'bdthemes-prime-slider' ),
					'bottom'       => esc_html__( 'Bottom', 'bdthemes-prime-slider' ),
					'bottom-end'   => esc_html__( 'Bottom Right', 'bdthemes-prime-slider' ),
					'left'         => esc_html__( 'Left', 'bdthemes-prime-slider' ),
					'right'        => esc_html__( 'Right', 'bdthemes-prime-slider' ),
				],
				'render_type' => 'template',
			]
		);

		$this->add_control(
			'marker_tooltip_x_offset',
			[ 
				'label'   => esc_html__( 'Offset', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'marker_tooltip_y_offset',
			[ 
				'label'   => esc_html__( 'Distance', 'bdthemes-prime-slider' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [ 
					'size' => 0,
				],
			]
		);
        
		$this->add_control(
			'marker_tooltip_arrow',
			[ 
				'label' => esc_html__( 'Arrow', 'bdthemes-prime-slider' ),
				'type'  => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'marker_tooltip_trigger',
			[ 
				'label'       => __( 'Trigger on Click', 'bdthemes-prime-slider' ),
				'description' => __( 'Don\'t set yes when you set lightbox image with marker.', 'bdthemes-prime-slider' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

		$this->end_controls_section();

        /**
         * Style
         */
        $this->start_controls_section(
            'section_style_image_hotspot',
            [
                'label' => esc_html__('Image Hotspot', 'ultimate-store-kit'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'hotspot_icon_color',
            [
                'label' => esc_html__('Icon Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'hotspot_background',
                'label' => esc_html__('Background', 'ultimate-store-kit'),
                'types' => ['classic', 'gradient'],
                'exclude' => [
                    'image',
                ],
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'hotspot_border',
                'label' => esc_html__('Border', 'ultimate-store-kit'),
                'selector' => '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'hotspot_border_radius',
            [
                'label' => esc_html__('Border Radius', 'ultimate-store-kit'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box, {{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'hotspot_size',
            [
                'label' => esc_html__('Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item' => 'width: {{SIZE}}{{UNIT}} !important; height: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'width: calc(24px + {{SIZE}}{{UNIT}}); height: calc(24px + {{SIZE}}{{UNIT}});',
                ],
            ]
        );
        $this->add_responsive_control(
            'hotspot_icon_size',
            [
                'label' => esc_html__('Icon Size', 'ultimate-store-kit'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-box' => 'font-size: {{SIZE}}px;',
                ],
                'condition' => [
                    'hotspot_type' => 'icon',
                ],
            ]
        );
        $this->add_control(
            'hotspot_pulse_color',
            [
                'label' => esc_html__('Shadow Pulse Color', 'ultimate-store-kit'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .usk-image-hotspot-thumbs .usk-thumbs-item:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render_add_to_cart() {
        global $product;
        $settings = $this->get_settings_for_display();
        if ('yes' == $settings['show_cart']) : ?>
        <?php if ($product) {
                $defaults = [
                    'quantity'   => 1,
                    'class'      => implode(
                        ' ',
                        array_filter(
                            [
                                'usk-button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
                            ]
                        )
                    ),
                    'attributes' => [
                        'data-product_id'  => $product->get_id(),
                        'data-product_sku' => $product->get_sku(),
                        'aria-label'       => $product->add_to_cart_description(),
                        'rel'              => 'nofollow',
                    ],
                ];
                $args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
                if (isset($args['attributes']['aria-label'])) {
                    $args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
                }
                echo wp_kses_post(apply_filters(
                    'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
                    sprintf(
                        '<a href="%s" data-quantity="%s" class="%s" %s>%s <i class="button-icon usk-icon-arrow-right-8"></i></a>',
                        esc_url($product->add_to_cart_url()),
                        esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
                        esc_attr(isset($args['class']) ? $args['class'] : 'button'),
                        isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : '',
                        esc_html($product->add_to_cart_text())
                    ),
                    $product,
                    $args
                ));
            }; ?>
        <?php endif;
    }

    public function render_image() {
        global $product;
        $tooltip_position = 'left';
        $settings = $this->get_settings_for_display();
        $gallery_thumbs = $product->get_gallery_image_ids();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['thumbnail_size']);
        if ($gallery_thumbs) {
            foreach ($gallery_thumbs as $key => $gallery_thumb) {
                if ($key == 0) :
                    $gallery_image_link = wp_get_attachment_image_url($gallery_thumb, $settings['thumbnail_size']);
                endif;
            }
        } else {
            $gallery_image_link = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['thumbnail_size']);
        }
        ?>
        <div class="usk-image">
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <img class="img image-default" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
                <img class="img image-hover" src="<?php echo esc_url($gallery_image_link); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
            </a>
            <?php $this->render_add_to_cart(); ?>
            <div class="usk-shoping">
                <?php $this->register_global_template_add_to_wishlist($tooltip_position); ?>
                <?php $this->register_global_template_add_to_compare($tooltip_position); ?>
                <?php $this->register_global_template_quick_view($product->get_id(), $tooltip_position); ?>
            </div>
            <div class="usk-badge-label-wrapper">
                <div class="usk-badge-label-content usk-flex usk-flex-column">
                    <?php $this->register_global_template_badge_label(); ?>
                </div>
            </div>
        </div>
        <?php
    }

    public function render_slider_header() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('image-hotspot', 'class', ['usk-image-hotspot usk-grid-carousel']);
        $id = 'image-hotspot-' . $this->get_id();

        $this->add_render_attribute('image-hotspot', 'id', $id);

        $this->add_render_attribute(
            [
                'image-hotspot' => [
                    'data-settings' => [
                        wp_json_encode(array_filter([
                            'id' => $id,
                            "slidesPerView" => isset($settings['product_limit']) ? $settings['product_limit'] : 3,
                            "watchSlidesProgress" => true,
                        ])),
                    ],
                ],
            ]
        );
        ?>
        <div class="ultimate-store-kit">
            <div <?php $this->print_render_attribute_string('image-hotspot');?>>
                <?php if ($settings['image_hotspot_layout'] == 'slider') : ?>
                <div class="swiper usk-image-hotspot-main">
                    <div class="swiper-wrapper">
                    <?php endif; 
    }

    public function render_slider_footer() {
        $settings = $this->get_settings_for_display();

        ?>
                <?php if ($settings['image_hotspot_layout'] == 'slider') : ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- thumbsslider -->
                <div thumbsSlider="" class="usk-image-hotspot-thumbs swiper">
                    <?php 
                    $placeholder_image_src = Utils::get_placeholder_image_src();
                    $image_src             = wp_get_attachment_image_src( $settings['hotspot_image']['id'], 'full' );
                    if ( ! $image_src ) {
                        printf( '<img src="%1$s" alt="%2$s">', esc_url( $placeholder_image_src ), esc_html( get_the_title() ) );
                    } else {
                        print( wp_get_attachment_image(
                            $settings['hotspot_image']['id'],
                            'full',
                            false,
                            [ 
            
                                'alt' => esc_html( get_the_title() )
                            ]
                        ) );
                    }
                    ?>
                    <div class="swiper-wrapper">
                        <?php $this->render_thumbs_item();?>
                    </div>
                </div>
                <!-- thumbsslider -->
            </div>
        </div>
        <?php
    }

    public function print_price_output($output) {
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

    public function render_product_content() {
		$settings = $this->get_settings_for_display();

        global $product;
        $rating_count = $product->get_rating_count();
        $average = $product->get_average_rating();
        $have_rating = ('yes' === $settings['show_rating']) ? 'usk-have-rating' : '';
        $categories = str_replace(',', '', wc_get_product_category_list($product->get_id()));

		?>
		<div class="swiper-slide usk-item <?php esc_attr_e($have_rating, 'ultimate-store-kit'); ?>">
            <div class="usk-item-box">
                <?php $this->render_image(); ?>
                <div class="usk-content">
                    <div class="usk-content-inner">
                        <?php if ('yes' == $settings['show_category']) : ?>
                            <?php printf('<%1$s class="usk-category">%2$s</%1$s>', esc_attr($settings['category_tags']), wp_kses_post($categories)); ?>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_title']) : ?>
                            <?php printf('<a href="%2$s" class="usk-title"><%1$s  class="title">%3$s</%1$s></a>', esc_attr($settings['title_tags']), esc_url($product->get_permalink()), esc_html($product->get_title())); ?>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_price']) : ?>
                            <div class="usk-price">
                                <?php $this->print_price_output($product->get_price_html()); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ('yes' == $settings['show_rating']) : ?>
                            <div class="usk-rating">
                                <span><?php echo wp_kses_post($this->register_global_template_wc_rating($average, $rating_count)); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

		<?php
	}

    public function render_tooltip_product_content() {
		ob_start();
		$html = '';
        $this->render_product_content();
		$html .= ob_get_clean();
		return $html;
	}

    public function render_loop_item() {
        $settings = $this->get_settings_for_display();

        $this->query_product();
        $wp_query = $this->get_query();

        if ($wp_query->have_posts()) { ?>
            <?php while ($wp_query->have_posts()) : $wp_query->the_post();
                

            ?>
                <?php $this->render_product_content();?>
            <?php endwhile;
            wp_reset_postdata();
        } else {
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        }
    }

    public function render_thumbs_image() {
        global $product;
        $settings = $this->get_settings_for_display();
        $product_image = wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['thumbnail_size']);
        ?>
        <div class="usk-image-wrap">
            <img class="usk-img" src="<?php echo esc_url($product_image); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
        </div>
        <?php
    }

    public function render_thumbs_item() {
        $settings = $this->get_settings_for_display();

        $hotspots = $settings['markers']; // Retrieve hotspots
        $unique_ids = []; // Initialize an array to store unique IDs
        if ($hotspots) {
            foreach ($hotspots as $hotspot) {
                $unique_ids[] = $hotspot['_id']; // Collect unique IDs
            }
        }

        $this->query_product();
        $wp_query = $this->get_query();
        
        if ($wp_query->have_posts()) { 
            $index = 0;
            
            while ($wp_query->have_posts()): $wp_query->the_post();
                global $product;

                
                $unique_id_class = isset($unique_ids[$index]) ? esc_attr($unique_ids[$index]) : '';
                
                if ($settings['image_hotspot_layout'] == 'tooltip') {
                    $marker_title = $this->render_tooltip_product_content();

                    $this->add_render_attribute( 'marker', 'class', 'usk-thumbs-item  elementor-repeater-item-' . esc_attr($unique_id_class), true );
    
                    $this->add_render_attribute( 'marker', 'data-tippy-content', $marker_title, true );
    
                    $this->add_render_attribute( 'marker', 'class', 'bdt-tippy-tooltip' );
                    $this->add_render_attribute( 'marker', 'data-tippy', '', true );
    
                    if ( $settings['marker_tooltip_animation'] ) {
                        $this->add_render_attribute( 'marker', 'data-tippy-animation', $settings['marker_tooltip_animation'], true );
                    }
    
                    if ( $settings['marker_tooltip_x_offset']['size'] or $settings['marker_tooltip_y_offset']['size'] ) {
                        $this->add_render_attribute( 'marker', 'data-tippy-offset', '[' . $settings['marker_tooltip_x_offset']['size'] . ',' . $settings['marker_tooltip_y_offset']['size'] . ']', true );
                    }
    
                    if ( 'yes' == $settings['marker_tooltip_arrow'] ) {
                        $this->add_render_attribute( 'marker', 'data-tippy-arrow', 'true', true );
                    } else {
                        $this->add_render_attribute( 'marker', 'data-tippy-arrow', 'false', true );
                    }
    
                    if ( 'yes' == $settings['marker_tooltip_trigger'] ) {
                        $this->add_render_attribute( 'marker', 'data-tippy-trigger', 'click', true );
                    }

                    if ( $settings['marker_tooltip_placement'] ) {
                        $this->add_render_attribute( 'marker', 'data-tippy-placement', $settings['marker_tooltip_placement'], true );
                    }
                } else {
                    $this->add_render_attribute( 'marker', 'class', 'swiper-slide usk-thumbs-item  elementor-repeater-item-' . esc_attr($unique_id_class), true );
                }

                ?>
                <div <?php echo $this->get_render_attribute_string( 'marker' ); ?>>
                    <div class="usk-thumbs-box">
                    <?php if ($settings['hotspot_type'] == 'image') : ?>
                        <?php $this->render_thumbs_image(); ?>
                        <?php else : ?>
                            <?php if ( $settings['hotspot_icon']['value'] ) : ?>
                                <?php Icons_Manager::render_icon( $settings['hotspot_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                            <?php else : ?>
                                <i class="usk-icon-plus-2" aria-hidden="true"></i>
                            <?php endif; ?>
                    <?php endif; ?>
                    </div>
                </div>
            <?php 
            $index++;
            endwhile;
        
            wp_reset_postdata();} else {
            echo '<div class="usk-alert-warning" usk-alert>' . esc_html__('Ops! There no product to display.', 'ultimate-store-kit') . '</div>';
        }
    }

    public function render() {
        $settings = $this->get_settings_for_display();

        $this->render_slider_header();

        if ($settings['image_hotspot_layout'] == 'slider') {
            $this->render_loop_item();
        }

        $this->render_slider_footer();
    }
    public function query_product() {
        $default = $this->getGroupControlQueryArgs();
        $this->_query = new WP_Query($default);
    }
}
