<?php

namespace UltimateStoreKit\Traits;

use Elementor\Plugin;

// use WP_Query;


defined('ABSPATH') || die();

trait Global_Widget_Template
{

	protected function register_templates_grid_columns_markup($settings)
	{ ?>
		<ul class="usk-grid-header-tabs">
			<?php if (in_array("list-2", $settings['filter_column_lists'])): ?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-1 usk-list-layout">
						<span class="usk-icon-grid-list"></span>
					</a>
				</li>
				<?php
			endif;
			if (in_array('grid-2', $settings['filter_column_lists'])):
				?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-2">
						<span class="usk-icon-grid-2"></span>
					</a>
				</li>
				<?php
			endif;
			if (in_array('grid-3', $settings['filter_column_lists'])):
				?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-3">
						<span class="usk-icon-grid-3"></span>
					</a>
				</li>
				<?php
			endif;
			if (in_array('grid-4', $settings['filter_column_lists'])):
				?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-4">
						<span class="usk-icon-grid-4"></span>
					</a>
				</li>
				<?php
			endif;
			if (in_array('grid-5', $settings['filter_column_lists'])):
				?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-5">
						<span class="usk-icon-grid-5"></span>
					</a>
				</li>
				<?php
			endif;
			if (in_array('grid-6', $settings['filter_column_lists'])):
				?>
				<li class="usk-grid-tabs-list">
					<a class="tab-option" href="javascript:void(0)" data-grid-column="usk-grid-6">
						<span class="usk-icon-grid-6"></span>
					</a>
				</li>
				<?php
			endif;
			?>
		</ul>
		<?php
	}

	protected function register_global_template_wc_rating($rating, $count = 0)
	{
		$html = '';
		if (
			0 <= $rating
		) {
			/* translators: %s: rating */
			// $label = sprintf(__('Rated %s out of 5', 'woocommerce'), $rating);
			$html = '<div class="star-rating" role="img">' . wc_get_star_rating_html($rating, $count) . '</div>';
		}

		return apply_filters('woocommerce_product_get_rating_html', $html, $rating, $count);
	}
	public function register_global_template_add_to_wishlist($tooltip_position, $settings)
	{
		global $product;
		$user_id = get_current_user_id();
		$product_id = $product->get_ID();
		$wishlist = ultimate_store_kit_get_wishlist($user_id);
		$is_wishlisted = in_array($product_id, $wishlist);
		if (!empty($is_wishlisted)) {
			$selected = ' usk-active';
			$tooltip = __('View Wishlist', 'ultimate-store-kit');
			$redirect_url = wc_get_account_endpoint_url('wishlist');
		} else {
			$selected = '';
			$tooltip = __('Add to Wishlist', 'ultimate-store-kit');
			$redirect_url = "javascript:void(0);";
		} ?>
		<?php if (isset($settings['show_wishlist']) ? $settings['show_wishlist'] : true): ?>
			<a href="<?php echo esc_url($redirect_url); ?>"
				class="usk-action-btn ajax_add_to_wishlist usk-shoping-icon-wishlist usk-btn usk-wishlist<?php echo esc_attr($selected); ?>"
				data-product_id="<?php echo absint($product_id); ?>" aria-label="<?php echo esc_html($tooltip); ?>"
				data-aria_label="<?php echo esc_html__('View Wishlist', 'ultimate-store-kit'); ?>"
				data-redirect_url="<?php echo esc_url(wc_get_account_endpoint_url('wishlist')); ?>"
				data-microtip-position="<?php echo esc_attr($tooltip_position); ?>" role="tooltip">
				<i class="icon usk-icon-heart-full"></i>
			</a>
		<?php endif; ?>
	<?php
	}

	function register_global_template_add_to_compare($tooltip_position, $settings)
	{
		global $product;
		$user_id = get_current_user_id();
		$product_id = $product->get_ID();
		$compare_products = usk_get_compare_products($user_id);
		$is_compared = in_array($product_id, $compare_products);

		$compare_page_id = '';
		if (function_exists('ultimate_store_kit_compare_product_page') && $comparePage = ultimate_store_kit_compare_product_page()) {
			$compare_page_id = $comparePage;
		}

		$compare_redirect_link = home_url();
		if ($compare_page_id) {
			$compare_redirect_link = get_page_link($compare_page_id);
		}

		if (!empty($is_compared)) {
			$tooltip = __('View Compare', 'ultimate-store-kit');
			$selected = 'usk-active';
			$compare_page_link = home_url();
			if ($compare_page_id) {
				$compare_page_link = get_page_link($compare_page_id);
			}
		} else {
			$tooltip = __('Add to Compare', 'ultimate-store-kit');
			$selected = '';
			$compare_page_link = "javascript:void(0);";
		} ?>
		<?php if (isset($settings['show_compare']) && $settings['show_compare'] == 'yes'): ?>
			<a href="<?php echo esc_url($compare_page_link); ?>"
				class="usk-action-btn ajax_add_to_compare usk-compare <?php echo esc_attr($selected); ?>"
				data-product_id="<?php echo esc_attr($product_id); ?>"
				data-redirect_url="<?php echo esc_url($compare_redirect_link); ?>" aria-label="<?php echo esc_html($tooltip); ?>"
				data-aria_label="<?php echo esc_html__('View Compare', 'ultimate-store-kit'); ?>"
				data-microtip-position="<?php echo esc_attr($tooltip_position); ?>" role="tooltip">
				<i class="icon usk-icon-compare"></i>
			</a>
			<?php
		?>
		<?php endif; ?>
	<?php

	}

	protected function register_global_template_quick_view($product_id, $tooltip_position, $settings)
	{
		// $settings = $this->get_settings_for_display();
		if (isset($settings['show_quick_view']) ? $settings['show_quick_view'] : true): ?>
			<?php wp_nonce_field('ajax-usk-quick-view-nonce', 'usk-quick-view-modal-sc');
			?>
			<a class="usk-action-btn usk-shoping-icon-quickview quick_view usk-view usk-btn" href="javascript:void(0)"
				data-id="<?php echo absint($product_id); ?>"
				aria-label="<?php echo esc_html__('Quick View', 'ultimate-store-kit'); ?>"
				data-microtip-position="<?php echo esc_attr($tooltip_position); ?>" role="tooltip">
				<i class="icon usk-icon-preview"></i>
			</a>
		<?php endif;
	}
	protected function register_global_template_add_to_cart($tooltip_position, $settings)
	{
		global $product;
		if (isset($settings['show_cart']) ? $settings['show_cart'] : true): ?>
			<?php if ($product) {
				$defaults = [
					'quantity' => 1,
					'class' => implode(
						' ',
						array_filter(
							[
								'usk-cart',
								'usk-action-btn',
								'product_type_' . $product->get_type(),
								$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
								$product->supports('ajax_add_to_cart') && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
							]
						)
					),
					'attributes' => [
						'data-product_id' => $product->get_id(),
						'data-product_sku' => $product->get_sku(),
						'data-microtip-position' => $tooltip_position,
						'aria-label' => $product->add_to_cart_text(),
						'rel' => 'nofollow',
						'role' => 'tooltip',
					],
				];
				$args = apply_filters('woocommerce_loop_add_to_cart_args', wp_parse_args($defaults), $product);
				if (isset($args['attributes']['aria-label'])) {
					$args['attributes']['aria-label'] = wp_strip_all_tags($args['attributes']['aria-label']);
				}
				echo wp_kses_post(apply_filters(
					'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
					sprintf(
						'<a href="%s" data-quantity="%s" class="%s" %s><i class="icon usk-icon-cart"></i></a>',
						esc_url($product->add_to_cart_url()),
						esc_attr(isset($args['quantity']) ? $args['quantity'] : 1),
						esc_attr(isset($args['class']) ? $args['class'] : 'button'),
						isset($args['attributes']) ? wc_implode_html_attributes($args['attributes']) : ''
					),
					$product,
					$args
				));
			}
			; ?>
		<?php endif;
	}
	protected function register_global_template_badge_label($settings)
	{
		// print_r($settings);
		global $product;
		if ($product->is_on_sale() && (isset($settings['show_sale_badge']) ? $settings['show_sale_badge'] : true)):
			printf('<div class="usk-badge-wrap usk-sale-badge"><span class="usk-badge">%1$s</span></div>', esc_html__('Sale', 'ultimate-store-kit'));
		endif;
		if (isset($settings['show_discount_badge']) ? $settings['show_discount_badge'] : true):
			$this->usk_get_badge_label_percentage();
		endif;
		if (isset($settings['show_stock_status']) && $settings['show_stock_status'] === 'yes'):
			if ($product->get_stock_status() === 'instock') {
				$stock_status = esc_html__('In Stock', 'ultimate-store-kit');
			} else {
				$stock_status = esc_html__('Out of Stock', 'ultimate-store-kit');
			}

			printf('<div class="usk-badge-wrap usk-stock-status-badge"><span class="usk-badge">%1$s</span></div>', esc_html($stock_status));
		endif;
		if ($product->is_featured() && (isset($settings['show_trending_badge']) ? $settings['show_trending_badge'] : true)):
			printf('<div class="usk-badge-wrap usk-trending-badge"><span class="usk-badge">%1$s</span></div>', esc_html__('Trending', 'ultimate-store-kit'));
		endif;
		if (isset($settings['show_new_badge']) ? $settings['show_new_badge'] : true):
			$newness_days = isset($settings['newness_days']) ? $settings['newness_days'] : 60;
			$created_date = strtotime($product->get_date_created());
			$valid_date = time() - (60 * 60 * 24 * $newness_days);
			if ($valid_date < $created_date) {
				printf('<div class="usk-badge-wrap usk-new-badge"><span class="usk-badge">%s</span></div>', esc_html__('New', 'ultimate-store-kit'));
			}
		endif;
	}
	protected function register_global_template_navigation()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' usk-visible@m' : '';

		if ('arrows' == $settings['navigation']): ?>
			<div style="direction: ltr;"
				class="usk-position-z-index usk-position-<?php echo esc_html($settings['arrows_position'] . $hide_arrow_on_mobile); ?>">
				<div class="usk-arrows-container usk-slidenav-container">
					<a href="" class="usk-navigation-prev usk-slidenav-previous usk-icon usk-slidenav">
						<i class="usk-icon-arrow-left-<?php echo esc_html($settings['nav_arrows_icon']); ?>" aria-hidden="true"></i>
					</a>
					<a href="" class="usk-navigation-next usk-slidenav-next usk-icon usk-slidenav">
						<i class="usk-icon-arrow-right-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
							aria-hidden="true"></i>
					</a>
				</div>
			</div>
		<?php endif;
	}
	protected function register_global_template_pagination()
	{
		$settings = $this->get_settings_for_display();

		if ('dots' == $settings['navigation'] or 'arrows-fraction' == $settings['navigation']): ?>
			<div class="usk-position-z-index usk-position-<?php echo esc_html($settings['dots_position']); ?>">
				<div class="usk-dots-container">
					<div class="swiper-pagination"></div>
				</div>
			</div>

		<?php elseif ('progressbar' == $settings['navigation']): ?>
			<div
				class="swiper-pagination usk-position-z-index usk-position-<?php echo esc_html($settings['progress_position']); ?>">
			</div>
		<?php endif;
	}
	protected function register_global_template_both_navigation()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'usk-visible@m usk-flex' : 'usk-flex';

		?>
		<div class="usk-position-z-index usk-position-<?php echo esc_html($settings['both_position']); ?>">
			<div class="usk-arrows-dots-container usk-slidenav-container ">

				<div class="usk-flex usk-flex-middle">
					<div class="<?php echo esc_html($hide_arrow_on_mobile); ?>">
						<a href="" class="usk-navigation-prev usk-slidenav-previous usk-icon usk-slidenav">
							<i class="usk-icon-arrow-left-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
								aria-hidden="true"></i>
						</a>
					</div>

					<?php if ('center' !== $settings['both_position']): ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>

					<div class="<?php echo esc_html($hide_arrow_on_mobile); ?>">
						<a href="" class="usk-navigation-next usk-slidenav-next usk-icon usk-slidenav">
							<i class="usk-icon-arrow-right-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
								aria-hidden="true"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
	protected function register_global_template_arrows_fraction()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'usk-visible@m' : ''; ?>
		<div class="usk-position-z-index usk-position-<?php echo esc_html($settings['arrows_fraction_position']); ?>">
			<div class="usk-arrows-fraction-container usk-slidenav-container ">

				<div class="usk-flex usk-flex-middle">
					<div class="<?php echo esc_html($hide_arrow_on_mobile); ?>">
						<a href="" class="usk-navigation-prev usk-slidenav-previous usk-icon usk-slidenav">
							<i class="usk-icon-arrow-left-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
								aria-hidden="true"></i>
						</a>
					</div>

					<?php if ('center' !== $settings['arrows_fraction_position']): ?>
						<div class="swiper-pagination"></div>
					<?php endif; ?>

					<div class="<?php echo esc_html($hide_arrow_on_mobile); ?>">
						<a href="" class="usk-navigation-next usk-slidenav-next usk-icon usk-slidenav">
							<i class="usk-icon-arrow-right-<?php echo esc_html($settings['nav_arrows_icon']); ?>"
								aria-hidden="true"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
		<?php
	}
	protected function usk_register_global_template_carousel_footer()
	{
		$settings = $this->get_settings_for_display(); ?>
		</div>
		<?php if ('yes' === $settings['show_scrollbar']): ?>
			<div class="swiper-scrollbar"></div>
		<?php endif; ?>
		</div>
		<?php if ('both' == $settings['navigation']): ?>
			<?php $this->register_global_template_both_navigation(); ?>
			<?php if ('center' === $settings['both_position']): ?>
				<div class="usk-position-z-index usk-position-bottom">
					<div class="usk-dots-container">
						<div class="swiper-pagination"></div>
					</div>
				</div>
			<?php endif; ?>
		<?php elseif ('arrows-fraction' == $settings['navigation']): ?>
			<?php $this->register_global_template_arrows_fraction(); ?>
			<?php if ('center' === $settings['arrows_fraction_position']): ?>
				<div class="usk-dots-container">
					<div class="swiper-pagination"></div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<?php $this->register_global_template_pagination() ?>
			<?php $this->register_global_template_navigation() ?>
		<?php endif; ?>
		</div>
		</div>
		</div>

		<?php
	}
	protected function register_global_template_carousel_header()
	{
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute('usk-carousel-wrapper', 'class', ['' . $this->get_name() . '', 'usk-grid-carousel']);
		$id = 'ultimate-store-kit-' . $this->get_id();
		$elementor_vp_lg = get_option('elementor_viewport_lg');
		$elementor_vp_md = get_option('elementor_viewport_md');
		$viewport_lg = !empty($elementor_vp_lg) ? $elementor_vp_lg - 1 : 1023;
		$viewport_md = !empty($elementor_vp_md) ? $elementor_vp_md - 1 : 767;
		$this->add_render_attribute('carousel', 'id', $id);
		$this->add_render_attribute('carousel', 'class', ['usk-carousel', 'usk-carousel-layout', 'elementor-swiper']);
		if ('arrows' == $settings['navigation']) {
			$this->add_render_attribute('carousel', 'class', 'usk-arrows-align-' . $settings['arrows_position']);
		} elseif ('dots' == $settings['navigation']) {
			$this->add_render_attribute('carousel', 'class', 'usk-dots-align-' . $settings['dots_position']);
		} elseif ('both' == $settings['navigation']) {
			$this->add_render_attribute('carousel', 'class', 'usk-arrows-dots-align-' . $settings['both_position']);
		} elseif ('arrows-fraction' == $settings['navigation']) {
			$this->add_render_attribute('carousel', 'class', 'usk-arrows-dots-align-' . $settings['arrows_fraction_position']);
		}

		if ('arrows-fraction' == $settings['navigation']) {
			$pagination_type = 'fraction';
		} elseif ('both' == $settings['navigation'] or 'dots' == $settings['navigation']) {
			$pagination_type = 'bullets';
		} elseif ('progressbar' == $settings['navigation']) {
			$pagination_type = 'progressbar';
		} else {
			$pagination_type = '';
		}

		$this->add_render_attribute(
			[
				'carousel' => [
					'data-settings' => [
						wp_json_encode(array_filter([
							"autoplay" => ("yes" == $settings["autoplay"]) ? ["delay" => $settings["autoplay_speed"]] : false,
							"loop" => ($settings["loop"] == "yes") ? true : false,
							"speed" => $settings["speed"]["size"],
							"pauseOnHover" => ("yes" == $settings["pauseonhover"]) ? true : false,
							"slidesPerView" => isset($settings["columns_mobile"]) ? (int) $settings["columns_mobile"] : 1,
							"slidesPerGroup" => isset($settings["slides_to_scroll_mobile"]) ? (int) $settings["slides_to_scroll_mobile"] : 1,
							"spaceBetween"   => !empty($settings["items_gap_mobile"]["size"]) ? (int)$settings["items_gap_mobile"]["size"] : 0,
							"centeredSlides" => ($settings["centered_slides"] === "yes") ? true : false,
							"grabCursor" => ($settings["grab_cursor"] === "yes") ? true : false,
							"effect" => $settings["skin"],
							"observer" => ($settings["observer"]) ? true : false,
							"observeParents" => ($settings["observer"]) ? true : false,
							// "direction"             => $settings['direction'],
							"watchSlidesVisibility" => true,
							"watchSlidesProgress" => true,
							"breakpoints" => [
								(int) $viewport_md => [
									"slidesPerView" => isset($settings["columns_tablet"]) ? (int) $settings["columns_tablet"] : 2,
									"spaceBetween"   => !empty($settings["items_gap_tablet"]["size"]) ? (int)$settings["items_gap_tablet"]["size"] : 0,
									"slidesPerGroup" => isset($settings["slides_to_scroll_tablet"]) ? (int) $settings["slides_to_scroll_tablet"] : 1,
								],
								(int) $viewport_lg => [
									"slidesPerView" => isset($settings["columns"]) ? (int) $settings["columns"] : 3,
									"spaceBetween"   => !empty($settings["items_gap"]["size"]) ? (int)$settings["items_gap"]["size"] : 0,
									"slidesPerGroup" => isset($settings["slides_to_scroll"]) ? (int) $settings["slides_to_scroll"] : 1,
								]
							],
							"navigation" => [
								"nextEl" => "#" . $id . " .usk-navigation-next",
								"prevEl" => "#" . $id . " .usk-navigation-prev",
							],
							"pagination" => [
								"el" => "#" . $id . " .swiper-pagination",
								"type" => $pagination_type,
								"clickable" => "true",
								'dynamicBullets' => ("yes" == $settings["dynamic_bullets"]) ? true : false,
							],
							"scrollbar" => [
								"el" => "#" . $id . " .swiper-scrollbar",
								"hide" => "true",
							],
							'coverflowEffect' => [
								'rotate' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_rotate"]["size"] : 50,
								'stretch' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_stretch"]["size"] : 0,
								'depth' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_depth"]["size"] : 100,
								'modifier' => ("yes" == $settings["coverflow_toggle"]) ? $settings["coverflow_modifier"]["size"] : 1,
								'slideShadows' => true,
							],

						]))
					]
				]
			]
		);

		$this->add_render_attribute('swiper', 'class', 'swiper-carousel swiper');

		?>

		<div class="ultimate-store-kit">
			<div <?php $this->print_render_attribute_string('usk-carousel-wrapper'); ?>>
				<div <?php $this->print_render_attribute_string('carousel'); ?>>
					<div <?php echo wp_kses_post($this->get_render_attribute_string('swiper')); ?>>
						<div class="swiper-wrapper">
							<?php
	}
	protected function usk_get_badge_label_percentage()
	{
		global $product;
		if ($product->is_on_sale()) {
			$percentage = '';
			if ($product->get_type() == 'variable') {
				$available_variations = $product->get_variation_prices();
				$max_percentage = 0;
				foreach ($available_variations['regular_price'] as $key => $regular_price) {
					$sale_price = $available_variations['sale_price'][$key];
					if ($sale_price < $regular_price) {
						$percentage = round((($regular_price - $sale_price) / $regular_price) * 100);
						if ($percentage > $max_percentage) {
							$max_percentage = $percentage;
						}
					}
				}
				$percentage = $max_percentage;
			} elseif (($product->get_type() == 'simple' || $product->get_type() == 'external')) {
				$percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
			}
			if ($percentage) {
				printf('<div class="usk-badge-wrap usk-percantage-badge"><span class="usk-badge">%1$s%2$s</span></div>', esc_html($percentage), esc_html__('% off', 'ultimate-store-kit'));
			}
		}
	}
	protected function render_navigation()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? ' bdt-visible@m' : '';

		if ('arrows' == $settings['navigation']): ?>
								<div
									class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['arrows_position'] . $hide_arrow_on_mobile); ?>">
									<div class="bdt-arrows-container bdt-slidenav-container">
										<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav">
											<i class="usk-icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
												aria-hidden="true"></i>
										</a>
										<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav">
											<i class="usk-icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
												aria-hidden="true"></i>
										</a>
									</div>
								</div>
								<?php
		endif;
	}

	protected function render_pagination()
	{
		$settings = $this->get_settings_for_display();

		if ('dots' == $settings['navigation'] or 'arrows-fraction' == $settings['navigation']): ?>
								<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['dots_position']); ?>">
									<div class="bdt-dots-container">
										<div class="swiper-pagination"></div>
									</div>
								</div>

								<?php
		elseif ('progressbar' == $settings['navigation']): ?>
								<div
									class="swiper-pagination bdt-position-z-index bdt-position-<?php echo esc_attr($settings['progress_position']); ?>">
								</div>
								<?php
		endif;
	}

	protected function render_both_navigation()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'bdt-visible@m' : '';

		?>
							<div class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['both_position']); ?>">
								<div class="bdt-arrows-dots-container bdt-slidenav-container ">

									<div class="bdt-flex bdt-flex-middle">
										<div class="<?php
										echo esc_attr($hide_arrow_on_mobile); ?>">
											<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav">
												<i class="usk-icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
													aria-hidden="true"></i>
											</a>
										</div>

										<?php
										if ('center' !== $settings['both_position']): ?>
											<div class="swiper-pagination"></div>
											<?php
										endif; ?>

										<div class="<?php
										echo esc_attr($hide_arrow_on_mobile); ?>">
											<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav">
												<i class="usk-icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
													aria-hidden="true"></i>
											</a>
										</div>

									</div>
								</div>
							</div>
							<?php
	}
	protected function render_arrows_fraction()
	{
		$settings = $this->get_settings_for_display();
		$hide_arrow_on_mobile = $settings['hide_arrow_on_mobile'] ? 'bdt-visible@m' : ''; ?>
							<div
								class="bdt-position-z-index bdt-position-<?php echo esc_attr($settings['arrows_fraction_position']); ?>">
								<div class="bdt-arrows-fraction-container bdt-slidenav-container ">

									<div class="bdt-flex bdt-flex-middle">
										<div class="<?php
										echo esc_attr($hide_arrow_on_mobile); ?>">
											<a href="" class="bdt-navigation-prev bdt-slidenav-previous bdt-icon bdt-slidenav">
												<i class="usk-icon-arrow-left-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
													aria-hidden="true"></i>
											</a>
										</div>

										<?php
										if ('center' !== $settings['arrows_fraction_position']): ?>
											<div class="swiper-pagination"></div>
											<?php
										endif; ?>

										<div class="<?php
										echo esc_attr($hide_arrow_on_mobile); ?>">
											<a href="" class="bdt-navigation-next bdt-slidenav-next bdt-icon bdt-slidenav">
												<i class="usk-icon-arrow-right-<?php echo esc_attr($settings['nav_arrows_icon']); ?>"
													aria-hidden="true"></i>
											</a>
										</div>

									</div>
								</div>
							</div>
							<?php
	}
	protected function render_footer()
	{
		$settings = $this->get_settings_for_display(); ?>
						</div>
						<?php
						if ('yes' === $settings['show_scrollbar']): ?>
							<div class="swiper-scrollbar"></div>
							<?php
						endif; ?>
					</div>

					<?php
					if ('both' == $settings['navigation']): ?>
						<?php $this->render_both_navigation(); ?>
						<?php
						if ('center' === $settings['both_position']): ?>
							<div class="bdt-position-z-index bdt-position-bottom">
								<div class="bdt-dots-container">
									<div class="swiper-pagination"></div>
								</div>
							</div>
							<?php
						endif; ?>
						<?php
					elseif ('arrows-fraction' == $settings['navigation']): ?>
						<?php $this->render_arrows_fraction(); ?>
						<?php
						if ('center' === $settings['arrows_fraction_position']): ?>
							<div class="bdt-dots-container">
								<div class="swiper-pagination"></div>
							</div>
							<?php
						endif; ?>
						<?php
					else: ?>
						<?php $this->render_pagination(); ?>
						<?php $this->render_navigation(); ?>
						<?php
					endif; ?>

				</div>
			</div>

			<?php
	}
}
