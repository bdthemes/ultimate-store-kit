<?php

use UltimateStoreKit\Ultimate_Store_Kit_Loader;
use Elementor\Plugin;

/**
 * You can easily add white label branding for for extended license or multi site license.
 * Don't try for regular license otherwise your license will be invalid.
 * return white label
 */

if (! defined('BDTUSK')) {
	define('BDTUSK', '');
}

//Add prefix for all widgets <span class="usk-widget-badge"></span>
if (! defined('BDTUSK_CP')) {
	define('BDTUSK_CP', '<span class="usk-widget-badge"></span>');
}

//Add prefix for all widgets <span class="usk-widget-badge"></span>
if (! defined('BDTUSK_NC')) {
	define('BDTUSK_NC', '<span class="usk-new-control"></span>');
}

// if you have any custom style
if (! defined('BDTUSK_SLUG')) {
	define('BDTUSK_SLUG', 'ultimate-store-kit');
}

// set your own alias
if (! defined('BDTUSK_VER')) {
	define('BDTUSK_VER', 'Ultimate Store Kit');
}

// Set your own name for plugin

if (! defined('BDTUSK_NAME')) {
	define('BDTUSK_NAME', 'Ultimate Store Kit');
}

if (_is_usk_pro_activated()) {
	if (! defined('BDTUSK_PC')) {
		define('BDTUSK_PC', '');
	} // pro control badge
	define('BDTUSK_IS_PC', '');
} else {
	if (! defined('BDTUSK_PC')) {
		define('BDTUSK_PC', '<span class="usk-pro-control"></span>');
	} // pro control badge
	define('BDTUSK_IS_PC', 'usk-disabled-control');
}

/**
 * Show any alert by this function
 *
 * @param mixed $message [description]
 * @param class prefix  $type    [description]
 * @param boolean $close [description]
 *
 * @return helper [description]
 */


function ultimate_store_kit_is_edit() {
	return Plugin::$instance->editor->is_edit_mode();
}

function ultimate_store_kit_is_preview() {
	return Plugin::$instance->preview->is_preview_mode();
}

function ultimate_store_kit_alert($message, $type = 'warning', $close = true) {
?>
	<div class="usk-alert-<?php echo esc_attr('$type'); ?>" usk-alert>
		<?php if ($close) : ?>
			<a class="usk-alert-close" usk-close></a>
		<?php endif; ?>
		<?php echo wp_kses_post($message); ?>
	</div>
	<?php
}

function ultimate_store_kit_get_alert($message, $type = 'warning', $close = true) {

	$output = '<div class="usk-alert-' . $type . '" usk-alert>';
	if ($close) :
		$output .= '<a class="usk-alert-close" usk-close></a>';
	endif;
	$output .= wp_kses_post($message);
	$output .= '</div>';

	return $output;
}

/**
 * all array css classes will output as proper space
 *
 * @param array $classes shortcode css class as array
 *
 * @return proper string
 */

function ultimate_store_kit_get_post_types($args = []) {

	$post_type_args = [
		'show_in_nav_menus' => true,
	];

	if (! empty($args['post_type'])) {
		$post_type_args['name'] = $args['post_type'];
	}

	$_post_types = get_post_types($post_type_args, 'objects');

	$post_types = ['0' => esc_html__('Select Type', 'ultimate-store-kit')];

	foreach ($_post_types as $post_type => $object) {
		$post_types[$post_type] = $object->label;
	}

	return $post_types;
}

/**
 * Add REST API support to an already registered post type.
 */

// function bdt_custom_post_type_rest_support() {

//     global $wp_post_types;

//     $post_types = ultimate_store_kit_get_post_types();

//     foreach( $post_types as $post_type ) {

//         $post_type_name = $post_type;

//         if( isset( $wp_post_types[ $post_type_name ] ) ) {

//             $wp_post_types[$post_type_name]->show_in_rest = true;

//             $wp_post_types[$post_type_name]->rest_base = $post_type_name;

//             $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';

//         }

//     }

// }

// add_action( 'init', 'bdt_custom_post_type_rest_support', 25 );

function ultimate_store_kit_allow_tags($tag = null) {
	$tag_allowed = wp_kses_allowed_html('post');

	$tag_allowed['input']  = [
		'class'   => [],
		'id'      => [],
		'name'    => [],
		'value'   => [],
		'checked' => [],
		'type'    => [],
	];
	$tag_allowed['select'] = [
		'class'    => [],
		'id'       => [],
		'name'     => [],
		'value'    => [],
		'multiple' => [],
		'type'     => [],
	];
	$tag_allowed['option'] = [
		'value'    => [],
		'selected' => [],
	];

	$tag_allowed['title'] = [
		'a'      => [
			'href'  => [],
			'title' => [],
			'class' => [],
		],
		'br'     => [],
		'em'     => [],
		'strong' => [],
		'hr'     => [],
	];

	$tag_allowed['text'] = [
		'a'      => [
			'href'  => [],
			'title' => [],
			'class' => [],
		],
		'br'     => [],
		'em'     => [],
		'strong' => [],
		'hr'     => [],
		'i'      => [
			'class' => [],
		],
		'span'   => [
			'class' => [],
		],
	];

	$tag_allowed['svg'] = [
		'svg'     => [
			'version'     => [],
			'xmlns'       => [],
			'viewbox'     => [],
			'xml:space'   => [],
			'xmlns:xlink' => [],
			'x'           => [],
			'y'           => [],
			'style'       => [],
		],
		'g'       => [],
		'path'    => [
			'class' => [],
			'd'     => [],
		],
		'ellipse' => [
			'class' => [],
			'cx'    => [],
			'cy'    => [],
			'rx'    => [],
			'ry'    => [],
		],
		'circle'  => [
			'class' => [],
			'cx'    => [],
			'cy'    => [],
			'r'     => [],
		],
		'rect'    => [
			'x'         => [],
			'y'         => [],
			'transform' => [],
			'height'    => [],
			'width'     => [],
			'class'     => [],
		],
		'line'    => [
			'class' => [],
			'x1'    => [],
			'x2'    => [],
			'y1'    => [],
			'y2'    => [],
		],
		'style'   => [],

	];

	if ($tag == null) {
		return $tag_allowed;
	} elseif (is_array($tag)) {
		$new_tag_allow = [];

		foreach ($tag as $_tag) {
			$new_tag_allow[$_tag] = $tag_allowed[$_tag];
		}

		return $new_tag_allow;
	} else {
		return isset($tag_allowed[$tag]) ? $tag_allowed[$tag] : [];
	}
}

/**
 * post pagination
 */
function ultimate_store_kit_post_pagination($wp_query) {

	/** Stop execution if there's only 1 page */

	if ($wp_query->max_num_pages <= 1) {
		return;
	}

	if (is_front_page()) {
		$paged = (get_query_var('page')) ? get_query_var('page') : 1;
	} else {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	}

	$max = intval($wp_query->max_num_pages);

	/** Add current page to the array */

	if ($paged >= 1) {
		$links[] = $paged;
	}

	/** Add the pages around the current page to the array */

	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<ul class="usk-pagination">' . "\n";

	/** Previous Post Link */

	if (get_previous_posts_link()) {
		printf('<li>%s</li>' . "\n", wp_kses_post(get_previous_posts_link('<span class="usk-icon-arrow-left-5"></span>')));
	}

	/** Link to first page, plus ellipses if necessary */

	if (! in_array(1, $links)) {
		$class = 1 == $paged ? ' class="current"' : '';

		printf('<li%s><a href="%s" target="_self">%s</a></li>' . "\n", wp_kses_post($class), esc_url(get_pagenum_link(1)), '1');

		if (! in_array(2, $links)) {
			echo '<li class="usk-pagination-dot-dot"><span>...</span></li>';
		}
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);

	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="usk-active"' : '';
		printf('<li%s><a href="%s" target="_self">%s</a></li>' . "\n", wp_kses_post($class), esc_url(get_pagenum_link($link)), esc_html($link));
	}

	/** Link to last page, plus ellipses if necessary */

	if (! in_array($max, $links)) {

		if (! in_array($max - 1, $links)) {
			echo '<li class="usk-pagination-dot-dot"><span>...</span></li>' . "\n";
		}

		$class = $paged == $max ? ' class="usk-active"' : '';
		printf('<li%s><a href="%s" target="_self">%s</a></li>' . "\n", wp_kses_post($class), esc_url(get_pagenum_link($max)), esc_html($max));
	}

	/** Next Post Link */

	if (get_next_posts_link()) {
		printf('<li>%s</li>' . "\n", wp_kses_post(get_next_posts_link('<span class="usk-icon-arrow-right-1"></span>')));
	}

	echo '</ul>' . "\n";
}
function ultimate_store_kit_post_pagination__new($wp_query) {
	$page  = max(1, get_query_var('paged'), get_query_var('page'));
	$page  = absint(empty($_GET['product-page']) ? $page : $_GET['product-page']);
	$paged = absint($page);

	/** Stop execution if there's only 1 page */
	if ($wp_query->max_num_pages <= 1) {
		return;
	}

	$max = intval($wp_query->max_num_pages);

	/** Add current page to the array */
	if ($paged >= 1) {
		$links[] = $paged;
	}

	/** Add the pages around the current page to the array */
	if ($paged >= 3) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if (($paged + 2) <= $max) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	// Get the current URL without any pagination parameters
	$current_url = remove_query_arg(['paged', 'page', 'product-page']);

	// If we're on a custom post type archive or taxonomy page, preserve the base URL
	if (is_post_type_archive() || is_tax()) {
		$current_url = get_pagenum_link(1, false);
		$current_url = remove_query_arg(['paged', 'page', 'product-page'], $current_url);
	}

	echo '<ul class="usk-pagination">' . "\n";

	/** Previous Post Link */
	if (get_previous_posts_link()) {
		$prev_page = $paged - 1;
		if ($prev_page < 1) {
			return;
		}
		$class = $paged == $prev_page ? ' class="current"' : '';
		printf(
			'<li%s><a href="%s" target="_self">%s</a></li>' . "\n",
			wp_kses_post($class),
			esc_url(add_query_arg('product-page', $prev_page, $current_url)),
			'<span class="usk-icon-arrow-left-5"></span>'
		);
	}

	/** Link to first page, plus ellipses if necessary */
	if (! in_array(1, $links)) {
		$class = 1 == $paged ? ' class="current"' : '';
		printf(
			'<li%s><a href="%s" target="_self">%s</a></li>' . "\n",
			wp_kses_post($class),
			esc_url(add_query_arg('product-page', '1', $current_url)),
			'1'
		);
		if (! in_array(2, $links)) {
			echo '<li class="usk-pagination-dot-dot"><span>...</span></li>';
		}
	}

	/** Link to current page, plus 2 pages in either direction if necessary */
	sort($links);
	foreach ((array) $links as $link) {
		$class = $paged == $link ? ' class="usk-active"' : '';
		printf(
			'<li%s><a href="%s" target="_self">%s</a></li>' . "\n",
			wp_kses_post($class),
			esc_url(add_query_arg('product-page', $link, $current_url)),
			esc_html($link)
		);
	}

	/** Link to last page, plus ellipses if necessary */
	if (! in_array($max, $links)) {
		if (! in_array($max - 1, $links)) {
			echo '<li class="usk-pagination-dot-dot"><span>...</span></li>' . "\n";
		}
		$class = $paged == $max ? ' class="usk-active"' : '';
		printf(
			'<li%s><a href="%s" target="_self">%s</a></li>' . "\n",
			wp_kses_post($class),
			esc_url(add_query_arg('product-page', $max, $current_url)),
			esc_html($max)
		);
	}

	/** Next Post Link */
	if (get_next_posts_link()) {
		$next_page = $paged + 1;
		if ($next_page > $max) {
			return;
		}
		printf(
			'<li%s><a href="%s" target="_self">%s</a></li>' . "\n",
			wp_kses_post($class),
			esc_url(add_query_arg('product-page', $next_page, $current_url)),
			'<span class="usk-icon-arrow-right-1"></span>'
		);
	}

	echo '</ul>' . "\n";
}

function ultimate_store_kit_template_edit_link($template_id) {

	if (Ultimate_Store_Kit_Loader::elementor()->editor->is_edit_mode()) {

		$final_url = add_query_arg(['elementor' => ''], get_permalink($template_id));

		$output = sprintf('<a class="usk-elementor-template-edit-link" href="%s" title="%s" target="_blank"><i class="usk-icon-edit"></i></a>', esc_url($final_url), esc_html__('Edit Template', 'ultimate-store-kit'));

		return $output;
	}
}

function ultimate_store_kit_iso_time($time) {
	$current_offset  = (float) get_option('gmt_offset');
	$timezone_string = get_option('timezone_string');

	// Create a UTC+- zone if no timezone string exists.

	//if ( empty( $timezone_string ) ) {
	if (0 === $current_offset) {
		$timezone_string = '+00:00';
	} elseif ($current_offset < 0) {
		$timezone_string = $current_offset . ':00';
	} else {
		$timezone_string = '+0' . $current_offset . ':00';
	}

	//}

	$sub_time   = [];
	$sub_time   = explode(" ", $time);
	$final_time = $sub_time[0] . 'T' . $sub_time[1] . ':00' . $timezone_string;

	return $final_time;
}

/**
 * @param $currency
 * @param int $precision
 *
 * @return false|string
 */
function ultimate_store_kit_currency_format($currency, $precision = 1) {

	if ($currency > 0) {

		if ($currency < 900) {
			// 0 - 900
			$currency_format = number_format($currency, $precision);
			$suffix          = '';
		} else

			if ($currency < 900000) {
			// 0.9k-850k
			$currency_format = number_format($currency / 1000, $precision);
			$suffix          = 'K';
		} else

				if ($currency < 900000000) {
			// 0.9m-850m
			$currency_format = number_format($currency / 1000000, $precision);
			$suffix          = 'M';
		} else

					if ($currency < 900000000000) {
			// 0.9b-850b
			$currency_format = number_format($currency / 1000000000, $precision);
			$suffix          = 'B';
		} else {
			// 0.9t+
			$currency_format = number_format($currency / 1000000000000, $precision);
			$suffix          = 'T';
		}

		// Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"

		// Intentionally does not affect partials, eg "1.50" -> "1.50"
		if ($precision > 0) {
			$dotzero         = '.' . str_repeat('0', $precision);
			$currency_format = str_replace($dotzero, '', $currency_format);
		}

		return $currency_format . $suffix;
	}

	return false;
}

/**
 * @return array
 */
function ultimate_store_kit_get_menu() {

	$menus = wp_get_nav_menus();
	$items = [0 => esc_html__('Select Menu', 'ultimate-store-kit')];
	foreach ($menus as $menu) {
		$items[$menu->slug] = $menu->name;
	}

	return $items;
}

/**
 * default get_option() default value check
 *
 * @param string $option settings field name
 * @param string $section the section name this field belongs to
 * @param string $default default text if it's not found
 *
 * @return mixed
 */
function ultimate_store_kit_option($option, $section, $default = '') {

	$options = get_option($section);

	if (isset($options[$option])) {
		return $options[$option];
	}

	return $default;
}

/**
 * @return array of elementor template
 */
function ultimate_store_kit_et_options() {

	$templates = Ultimate_Store_Kit_Loader::elementor()->templates_manager->get_source('local')->get_items();
	$types     = [];

	if (empty($templates)) {
		$template_options = ['0' => __('Template Not Found!', 'ultimate-store-kit')];
	} else {
		$template_options = ['0' => __('Select Template', 'ultimate-store-kit')];

		foreach ($templates as $template) {
			$template_options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
			$types[$template['template_id']]            = $template['type'];
		}
	}

	return $template_options;
}

/**
 * @return array of wp default sidebars
 */
function ultimate_store_kit_sidebar_options() {

	global $wp_registered_sidebars;
	$sidebar_options = [];

	if (! $wp_registered_sidebars) {
		$sidebar_options[0] = esc_html__('No sidebars were found', 'ultimate-store-kit');
	} else {
		$sidebar_options[0] = esc_html__('Select Sidebar', 'ultimate-store-kit');

		foreach ($wp_registered_sidebars as $sidebar_id => $sidebar) {
			$sidebar_options[$sidebar_id] = $sidebar['name'];
		}
	}

	return $sidebar_options;
}

/**
 * @param string category name
 *
 * @return array of category
 */
function ultimate_store_kit_get_category($taxonomy = 'product_cat') {

	$post_options = [];

	$post_categories = get_terms([
		'taxonomy'   => $taxonomy,
		'hide_empty' => false,
	]);

	if (is_wp_error($post_categories)) {
		return $post_options;
	}

	if (false !== $post_categories and is_array($post_categories)) {
		foreach ($post_categories as $category) {
			// Ensure $category is an object, not an array
			if (is_object($category) && isset($category->term_id, $category->name)) {
				$post_options[$category->term_id] = $category->name;
			}
		}
	}

	return $post_options;
}

/**
 * @param string parent category name
 * @return array of parent category
 */
function ultimate_store_kit_get_only_parent_cats($taxonomy = 'category') {

	$parent_categories = ['none' => __('None', 'ultimate-store-kit')];
	$args              = ['parent' => 0];
	$parent_cats       = get_terms($taxonomy, $args);

	foreach ($parent_cats as $parent_cat) {
		// Ensure $parent_cat is an object, not an array
		if (is_object($parent_cat) && isset($parent_cat->term_id, $parent_cat->name)) {
			$parent_categories[$parent_cat->term_id] = ucfirst($parent_cat->name);
		}
	}

	return $parent_categories;
}

/**
 * @param array all ajax posted array there
 *
 * @return array return all setting as array
 */
function ultimate_store_kit_ajax_settings($settings) {

	$required_settings = [
		'show_date'      => true,
		'show_comment'   => true,
		'show_link'      => true,
		'show_meta'      => true,
		'show_title'     => true,
		'show_excerpt'   => true,
		'show_lightbox'  => true,
		'show_thumbnail' => true,
		'show_category'  => false,
		'show_tags'      => false,
	];

	foreach ($settings as $key => $value) {
		if (in_array($key, $required_settings)) {
			$required_settings[$key] = $value;
		}
	}

	return $required_settings;
}

/**
 * @return array of all transition names
 */
function ultimate_store_kit_transition_options() {

	$transition_options = [
		''                    => esc_html__('None', 'ultimate-store-kit'),
		'fade'                => esc_html__('Fade', 'ultimate-store-kit'),
		'scale-up'            => esc_html__('Scale Up', 'ultimate-store-kit'),
		'scale-down'          => esc_html__('Scale Down', 'ultimate-store-kit'),
		'slide-top'           => esc_html__('Slide Top', 'ultimate-store-kit'),
		'slide-bottom'        => esc_html__('Slide Bottom', 'ultimate-store-kit'),
		'slide-left'          => esc_html__('Slide Left', 'ultimate-store-kit'),
		'slide-right'         => esc_html__('Slide Right', 'ultimate-store-kit'),
		'slide-top-small'     => esc_html__('Slide Top Small', 'ultimate-store-kit'),
		'slide-bottom-small'  => esc_html__('Slide Bottom Small', 'ultimate-store-kit'),
		'slide-left-small'    => esc_html__('Slide Left Small', 'ultimate-store-kit'),
		'slide-right-small'   => esc_html__('Slide Right Small', 'ultimate-store-kit'),
		'slide-top-medium'    => esc_html__('Slide Top Medium', 'ultimate-store-kit'),
		'slide-bottom-medium' => esc_html__('Slide Bottom Medium', 'ultimate-store-kit'),
		'slide-left-medium'   => esc_html__('Slide Left Medium', 'ultimate-store-kit'),
		'slide-right-medium'  => esc_html__('Slide Right Medium', 'ultimate-store-kit'),
	];

	return $transition_options;
}

// BDT Blend Type
function ultimate_store_kit_blend_options() {
	$blend_options = [
		'multiply'    => esc_html__('Multiply', 'ultimate-store-kit'),
		'screen'      => esc_html__('Screen', 'ultimate-store-kit'),
		'overlay'     => esc_html__('Overlay', 'ultimate-store-kit'),
		'darken'      => esc_html__('Darken', 'ultimate-store-kit'),
		'lighten'     => esc_html__('Lighten', 'ultimate-store-kit'),
		'color-dodge' => esc_html__('Color-Dodge', 'ultimate-store-kit'),
		'color-burn'  => esc_html__('Color-Burn', 'ultimate-store-kit'),
		'hard-light'  => esc_html__('Hard-Light', 'ultimate-store-kit'),
		'soft-light'  => esc_html__('Soft-Light', 'ultimate-store-kit'),
		'difference'  => esc_html__('Difference', 'ultimate-store-kit'),
		'exclusion'   => esc_html__('Exclusion', 'ultimate-store-kit'),
		'hue'         => esc_html__('Hue', 'ultimate-store-kit'),
		'saturation'  => esc_html__('Saturation', 'ultimate-store-kit'),
		'color'       => esc_html__('Color', 'ultimate-store-kit'),
		'luminosity'  => esc_html__('Luminosity', 'ultimate-store-kit'),
	];

	return $blend_options;
}

// BDT Position
function ultimate_store_kit_position() {
	$position_options = [
		''              => esc_html__('Default', 'ultimate-store-kit'),
		'top-left'      => esc_html__('Top Left', 'ultimate-store-kit'),
		'top-center'    => esc_html__('Top Center', 'ultimate-store-kit'),
		'top-right'     => esc_html__('Top Right', 'ultimate-store-kit'),
		'center'        => esc_html__('Center', 'ultimate-store-kit'),
		'center-left'   => esc_html__('Center Left', 'ultimate-store-kit'),
		'center-right'  => esc_html__('Center Right', 'ultimate-store-kit'),
		'bottom-left'   => esc_html__('Bottom Left', 'ultimate-store-kit'),
		'bottom-center' => esc_html__('Bottom Center', 'ultimate-store-kit'),
		'bottom-right'  => esc_html__('Bottom Right', 'ultimate-store-kit'),
	];

	return $position_options;
}

// BDT Thumbnavs Position
function ultimate_store_kit_thumbnavs_position() {
	$position_options = [
		'top-left'      => esc_html__('Top Left', 'ultimate-store-kit'),
		'top-center'    => esc_html__('Top Center', 'ultimate-store-kit'),
		'top-right'     => esc_html__('Top Right', 'ultimate-store-kit'),
		'center-left'   => esc_html__('Center Left', 'ultimate-store-kit'),
		'center-right'  => esc_html__('Center Right', 'ultimate-store-kit'),
		'bottom-left'   => esc_html__('Bottom Left', 'ultimate-store-kit'),
		'bottom-center' => esc_html__('Bottom Center', 'ultimate-store-kit'),
		'bottom-right'  => esc_html__('Bottom Right', 'ultimate-store-kit'),
	];

	return $position_options;
}

function ultimate_store_kit_navigation_position() {
	$position_options = [
		'top-left'      => esc_html__('Top Left', 'ultimate-store-kit'),
		'top-center'    => esc_html__('Top Center', 'ultimate-store-kit'),
		'top-right'     => esc_html__('Top Right', 'ultimate-store-kit'),
		'center'        => esc_html__('Center', 'ultimate-store-kit'),
		'bottom-left'   => esc_html__('Bottom Left', 'ultimate-store-kit'),
		'bottom-center' => esc_html__('Bottom Center', 'ultimate-store-kit'),
		'bottom-right'  => esc_html__('Bottom Right', 'ultimate-store-kit'),
	];

	return $position_options;
}

function ultimate_store_kit_pagination_position() {
	$position_options = [
		'top-left'      => esc_html__('Top Left', 'ultimate-store-kit'),
		'top-center'    => esc_html__('Top Center', 'ultimate-store-kit'),
		'top-right'     => esc_html__('Top Right', 'ultimate-store-kit'),
		'bottom-left'   => esc_html__('Bottom Left', 'ultimate-store-kit'),
		'bottom-center' => esc_html__('Bottom Center', 'ultimate-store-kit'),
		'bottom-right'  => esc_html__('Bottom Right', 'ultimate-store-kit'),
	];

	return $position_options;
}

// BDT Drop Position
function ultimate_store_kit_drop_position() {
	$drop_position_options = [
		'bottom-left'    => esc_html__('Bottom Left', 'ultimate-store-kit'),
		'bottom-center'  => esc_html__('Bottom Center', 'ultimate-store-kit'),
		'bottom-right'   => esc_html__('Bottom Right', 'ultimate-store-kit'),
		'bottom-justify' => esc_html__('Bottom Justify', 'ultimate-store-kit'),
		'top-left'       => esc_html__('Top Left', 'ultimate-store-kit'),
		'top-center'     => esc_html__('Top Center', 'ultimate-store-kit'),
		'top-right'      => esc_html__('Top Right', 'ultimate-store-kit'),
		'top-justify'    => esc_html__('Top Justify', 'ultimate-store-kit'),
		'left-top'       => esc_html__('Left Top', 'ultimate-store-kit'),
		'left-center'    => esc_html__('Left Center', 'ultimate-store-kit'),
		'left-bottom'    => esc_html__('Left Bottom', 'ultimate-store-kit'),
		'right-top'      => esc_html__('Right Top', 'ultimate-store-kit'),
		'right-center'   => esc_html__('Right Center', 'ultimate-store-kit'),
		'right-bottom'   => esc_html__('Right Bottom', 'ultimate-store-kit'),
	];

	return $drop_position_options;
}

// Button Size
function ultimate_store_kit_button_sizes() {
	$button_sizes = [
		'xs' => esc_html__('Extra Small', 'ultimate-store-kit'),
		'sm' => esc_html__('Small', 'ultimate-store-kit'),
		'md' => esc_html__('Medium', 'ultimate-store-kit'),
		'lg' => esc_html__('Large', 'ultimate-store-kit'),
		'xl' => esc_html__('Extra Large', 'ultimate-store-kit'),
	];

	return $button_sizes;
}

// Button Size
function ultimate_store_kit_heading_size() {
	$heading_sizes = [
		'h1' => 'H1',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6',
	];

	return $heading_sizes;
}

// Title Tags
function ultimate_store_kit_title_tags() {
	$title_tags = [
		'h1'   => 'H1',
		'h2'   => 'H2',
		'h3'   => 'H3',
		'h4'   => 'H4',
		'h5'   => 'H5',
		'h6'   => 'H6',
		'div'  => 'div',
		'span' => 'span',
		'p'    => 'p',
	];

	return $title_tags;
}

function ultimate_store_kit_mask_shapes() {
	$path       = BDTUSK_ASSETS_URL . 'images/mask/';
	$shape_name = 'shape';
	$extension  = '.svg';
	$list       = [0 => esc_html__('Select Mask', 'ultimate-store-kit')];

	for ($i = 1; $i <= 20; $i++) {
		$list[$path . $shape_name . '-' . $i . $extension] = ucwords($shape_name . ' ' . $i);
	}

	return $list;
}

/**
 * This is a svg file converter function which return a svg content
 *
 * @param svg file
 *
 * @return svg content
 */
function ultimate_store_kit_svg_icon($icon) {

	$icon_path = BDTUSK_ASSETS_PATH . "images/svg/{$icon}.svg";

	if (! file_exists($icon_path)) {
		return false;
	}

	ob_start();

	include $icon_path;

	$svg = ob_get_clean();

	return $svg;
}

/**
 * @param array CSV file data
 * @param string $delimiter
 * @param false $header
 *
 * @return string
 */
function ultimate_store_kit_parse_csv($csv, $delimiter = ';', $header = true) {

	if (! is_string($csv)) {
		return '';
	}

	if (! function_exists('str_getcsv')) {
		return $csv;
	}

	$html    = '';
	$rows    = explode(PHP_EOL, $csv);
	$headRow = 1;

	foreach ($rows as $row) {

		if ($headRow == 1 and $header) {
			$html .= '<thead><tr>';
		} else {
			$html .= '<tr>';
		}

		foreach (str_getcsv($row, $delimiter) as $cell) {

			$cell = trim($cell);

			$html .= $header
				? '<th>' . $cell . '</th>'
				: '<td>' . $cell . '</td>';
		}

		if ($headRow == 1 and $header) {
			$html .= '</tr></thead><tbody>';
		} else {
			$html .= '</tr>';
		}

		$headRow++;
		$header = false;
	}

	return '<table>' . $html . '</tbody></table>';
}

function ultimate_store_kit_dashboard_link($suffix = '#welcome') {
	return add_query_arg(['page' => 'ultimate_store_kit_options' . $suffix], admin_url('admin.php'));
}

/**
 * @param int $limit default limit is 25 word
 * @param bool $strip_shortcode if you want to strip shortcode from excert text
 * @param string $trail trail string default is ...
 *
 * @return string return custom limited excerpt text
 */
function ultimate_store_kit_custom_excerpt($limit = 25, $strip_shortcode = false, $trail = '') {

	$output = get_the_content();

	if ($limit) {
		$output = wp_trim_words($output, $limit, $trail);
	}

	if ($strip_shortcode) {
		$output = strip_shortcodes($output);
	}

	return wpautop($output);
}

function usk_get_order_options() {
	$options = [
		'title'              => __('Title', 'ultimate-store-kit'),
		'ID'                 => __('ID', 'ultimate-store-kit'),
		'date'               => __('Date', 'ultimate-store-kit'),
		'rand'               => __('Random', 'ultimate-store-kit'),
		'_price'             => __('Product Price', 'ultimate-store-kit'),
		'total_sales'        => __('Top Seller', 'ultimate-store-kit'),
		'comment_count'      => __('Most Reviewed', 'ultimate-store-kit'),
		'_wc_average_rating' => __('Top Rated', 'ultimate-store-kit'),
	];

	return apply_filters('usk_order_options', $options);
}

//wishlist
function ultimate_store_kit_get_wishlist($user_id = 0) {
	$_wishlist_key = '_ultimate_store_kit_wishlist';
	$_wishlist     = [];

	if (isset($_COOKIE[$_wishlist_key])) {
		$cookie_data  = stripslashes($_COOKIE[$_wishlist_key]);
		$decoded_data = json_decode($cookie_data, true);

		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_data)) {
			$_wishlist = $decoded_data;
		}
	}

	return apply_filters('ultimate_store_kit_wishlist', array_unique($_wishlist));
}

function usk_get_taxonomies() {
	$taxonomy_list = get_object_taxonomies('product');
	$taxonomies    = [
		'search'  => 'Search',
		'price'   => 'Price',
		'orderby' => 'Orderby',
		'order'   => 'Order',
	];

	foreach ($taxonomy_list as $_taxonomy) {
		$taxonomy = get_taxonomy($_taxonomy);

		if ($taxonomy->show_ui) {
			$taxonomies[$_taxonomy] = $taxonomy->label;
		}
	}

	return $taxonomies;
}

function ultimate_store_kit_hide_on_class($selectors) {
	$element_hide_on = '';

	if (! empty($selectors)) {

		foreach ($selectors as $element) {

			if ($element == 'desktop') {
				$element_hide_on .= ' usk-hide-desktop';
			}

			if ($element == 'tablet') {
				$element_hide_on .= ' usk-hide-tablet';
			}

			if ($element == 'mobile') {
				$element_hide_on .= ' usk-hide-mobile';
			}
		}
	}

	return $element_hide_on;
}

function ultimate_store_kit_wc_product_quick_view_content($product_id) {
	wp_verify_nonce('ajax-usk-quick-view-nonce', 'usk-quick-view-modal-sc');
	global $woocommerce;
	global $post;

	if (intval($product_id)) {
		$post      = get_post($product_id);
		$next_post = get_next_post();
		$prev_post = get_previous_post();

		wp('p=' . $product_id . '&post_type=product');
		ob_start();
	?>
		<div class="usk-modal-page">
			<?php
			while (have_posts()) :
				the_post(); ?>
				<div class="usk-modal-product">
					<div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
						<div class="usk-modal-image-wrapper">
							<?php do_action('ultimate_store_kit_quick_florence_grid_view_product_images'); ?>
							<div class="usk-onsale">
								<?php do_action('ultimate_store_kit_wc_product_quick_view_product_sale_flash'); ?>
							</div>
						</div>
						<div class="usk-modal-content-box">
							<a href="<?php echo esc_url(get_permalink()); ?>" class="usk-product-title">
								<?php do_action('ultimate_store_kit_quick_view_product_title'); ?>
							</a>
							<div class="usk-rating">
								<?php do_action('ultimate_store_kit_quick_view_product_single_rating'); ?>
							</div>
							<div class="usk-product-price">
								<?php do_action('ultimate_store_kit_quick_view_product_single_price'); ?>
							</div>
							<div class="usk-product-meta">
								<div class="usk-sku-wrapper">
									<?php do_action('ultimate_store_kit_quick_view_product_single_meta'); ?>
								</div>
							</div>
							<div class="usk-product-desc">
								<?php do_action('ultimate_store_kit_quick_view_product_single_excerpt'); ?>
							</div>

							<div class="usk-quick-action-wrap">
								<?php do_action('ultimate_store_kit_quick_view_product_single_add_to_cart'); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>

		<?php
		$content = ob_get_clean();
		echo wp_kses_post($content);
		?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				// Load required WooCommerce scripts
				var scripts = [
					'<?php echo esc_url(plugins_url('assets/js/prettyPhoto/jquery.prettyPhoto.init.js', WC_PLUGIN_FILE)); ?>',
					'<?php echo esc_url(plugins_url('assets/js/frontend/add-to-cart-variation.min.js', WC_PLUGIN_FILE)); ?>',
					'<?php echo esc_url(plugins_url('assets/js/frontend/add-to-cart.min.js', WC_PLUGIN_FILE)); ?>',
					'<?php echo esc_url(plugins_url('assets/js/frontend/single-product.min.js', WC_PLUGIN_FILE)); ?>'
				];

				// Load scripts sequentially
				function loadScript(index) {
					if (index >= scripts.length) {
						initializeWooCommerce();
						return;
					}

					$.getScript(scripts[index], function() {
						loadScript(index + 1);
					});
				}

				function initializeWooCommerce() {
					// Initialize WooCommerce add to cart functionality
					var wc_add_to_cart_variation_params = {
						"ajax_url": "<?php echo admin_url('admin-ajax.php'); ?>",
						"i18n_view_cart": "<?php echo esc_js(__('View cart', 'ultimate-store-kit')); ?>",
						"cart_url": "<?php echo esc_url(wc_get_cart_url()); ?>",
						"is_cart": "<?php echo is_cart() ? '1' : '0'; ?>",
						"cart_redirect_after_add": "<?php echo get_option('woocommerce_cart_redirect_after_add') ? '1' : '0'; ?>"
					};

					// Initialize variation forms
					$(document.body).trigger('wc_variation_form');

					// Initialize add to cart buttons
					$(document.body).trigger('wc_fragments_refreshed');
					$(document.body).trigger('wc_fragments_loaded');
					$(document.body).trigger('added_to_cart');
				}

				// Start loading scripts
				// loadScript(0);
			});
		</script>
	<?php
		exit();
	}
}

function ultimate_store_kit_quick_view_product_images() {
	global $post, $product; ?>
	<div class="images">
		<?php

		if (has_post_thumbnail()) {
			$attachment_count = count($product->get_gallery_image_ids());
			$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
			$props            = wc_get_product_attachment_props(get_post_thumbnail_id(), $post);
			$image            = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), [
				'title' => $props['title'],
				'alt'   => $props['alt'],
			]);
			echo wp_kses_post(apply_filters('woocommerce_single_product_image_html', sprintf('<a href="%s" itemprop="image" class="usk-product woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $props['url'], $props['caption'], $image), $post->ID));
		} else {
			echo wp_kses_post(apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), esc_html__('Placeholder', 'ultimate-store-kit')), $post->ID));
		}

		$attachment_ids = $product->get_gallery_image_ids();

		if ($attachment_ids) :
			$loop    = 0;
			$columns = apply_filters('woocommerce_product_thumbnails_columns', 3);
		?>
			<div class="thumbnails columns-<?php echo esc_attr($columns); ?>">
				<?php

				foreach ($attachment_ids as $attachment_id) {
					$classes = ['thumbnail'];

					if ($loop === 0 || $loop % $columns === 0) {
						$classes[] = 'first';
					}

					if (($loop + 1) % $columns === 0) {
						$classes[] = 'last';
					}

					$image_link = wp_get_attachment_url($attachment_id);

					if (! $image_link) {
						continue;
					}

					$image_title   = esc_attr(get_the_title($attachment_id));
					$image_caption = esc_attr(get_post_field('post_excerpt', $attachment_id));
					$image         = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), 0, $attr = [
						'title' => $image_title,
						'alt'   => $image_title,
					]);
					$image_class = esc_attr(implode(' ', $classes));
					echo wp_kses_post(apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<a href="%s" class="%s" title="%s" >%s</a>', $image_link, $image_class, $image_caption, $image), $attachment_id, $post->ID, $image_class));
					$loop++;
				}

				?>
			</div>
		<?php endif; ?>
	</div>
<?php
}


/**
 * License Validation
 */
if (! function_exists('usk_license_validation')) {
	function usk_license_validation() {

		if (function_exists('_is_usk_pro_activated') && false === _is_usk_pro_activated()) {
			return false;
		}

		$license_key = trim(get_option('ultimate_post_kit_license_key'));

		if (isset($license_key) && ! empty($license_key)) {
			return true;
		} else {
			return false;
		}
		return false;
	}
}



function usk_get_compare_products($user_id = 0) {
	$_compare_products_key = '_ultimate_store_kit_compare_products';
	$_compare_products     = [];
	if ($user_id != 0) {
		$_compare_products = get_user_meta($user_id, $_compare_products_key, true) ?: [];
	} elseif (isset($_COOKIE[$_compare_products_key])) {
		//$_compare_products = unserialize(stripslashes($_COOKIE[sanitize_text_field($_compare_products_key)]));

		$cookie_value      = sanitize_text_field($_COOKIE[$_compare_products_key]);
		$_compare_products = json_decode(stripslashes($cookie_value), true);

		// Check if JSON decoding failed
		if (! is_array($_compare_products)) {
			$_compare_products = [];
		}
	}

	return apply_filters('ultimate_store_kit_compare_products', array_unique($_compare_products));
}

function usk_get_compare_products_count() {
	$count    = 0;
	$user_id  = get_current_user_id();
	$products = usk_get_compare_products($user_id);
	if (is_array($products)) {
		$count = count($products);
	}
	return $count;
}

//if (!function_exists('ultimate_store_kit_get_compare_product_slug')) {
//    function ultimate_store_kit_compare_product_slug() {
//        return 'compare-products';
//    }
//}

if (! function_exists('ultimate_store_kit_compare_product_page')) {
	function ultimate_store_kit_compare_product_page() {
		if ($postId = intval(get_option('bdt_usk_compare_products_page_id'))) {
			$post = get_post($postId);
			if ($post && $post->post_status == 'publish') {
				return $post->ID;
			}
		}
	}
}

if (! function_exists('ultimate_store_kit_is_compare_product_page')) {
	function ultimate_store_kit_is_compare_product_page() {
		if ($page = ultimate_store_kit_compare_product_page()) {
			// return is_page( $page->ID );
			return is_page($page);
		}
	}
}

/**
 * Helper function to check if variation swatches Pro is active
 *
 * @return bool
 */
function usk_has_variation_swatches_support() {
	return class_exists('UltimateStoreKitPro\\VariationSwatches\\Swatches');
}

/**
 * Helper function to load variation swatches scripts and styles
 */
function usk_load_variation_swatches_assets() {
	// Always load the grid variations script for variation support
	wp_register_script('usk-grid-variations', BDTUSK_ASSETS_URL . 'js/modules/usk-grid-variations.min.js', ['jquery'], BDTUSK_VER, true);
	wp_localize_script('usk-grid-variations', 'usk_vars', array(
		'ajax_url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('usk_variations')
	));
}
add_action('wp_enqueue_scripts', 'usk_load_variation_swatches_assets', 20);

// Hook into AJAX variation selection to update product image
function usk_ajax_variation_image_update() {
	if (!isset($_POST['variation_id']) || !isset($_POST['product_id'])) {
		wp_send_json_error('Missing required parameters');
		return;
	}

	$variation_id = absint($_POST['variation_id']);
	$product_id = absint($_POST['product_id']);

	$variation = wc_get_product($variation_id);
	if (!$variation) {
		wp_send_json_error('Invalid variation');
		return;
	}

	$image_id = $variation->get_image_id();
	$image_url = '';

	if ($image_id) {
		$image_url = wp_get_attachment_image_url($image_id, 'woocommerce_thumbnail');
	} else {
		// If variation has no image, use the parent product image
		$parent = wc_get_product($product_id);
		$parent_image_id = $parent->get_image_id();
		if ($parent_image_id) {
			$image_url = wp_get_attachment_image_url($parent_image_id, 'woocommerce_thumbnail');
		}
	}

	wp_send_json_success(array('image_url' => $image_url));
}
add_action('wp_ajax_usk_get_variation_image', 'usk_ajax_variation_image_update');
add_action('wp_ajax_nopriv_usk_get_variation_image', 'usk_ajax_variation_image_update');

// Start: Add to cart quantity buttons conversion
if ( ! function_exists( 'usk_display_quantity_minus' ) ) {
	function usk_display_quantity_minus() {
		if ( ! is_product() ) return;
		echo '<button type="button" class="bdt-add-to-cart-qty-minus" ><i class="usk-icon-minus3"></i></button>';
	}
}

if ( ! function_exists( 'usk_display_quantity_plus' ) ) {	
	function usk_display_quantity_plus() {
		if ( ! is_product() ) return;
		echo '<button type="button" class="bdt-add-to-cart-qty-plus" ><i class="usk-icon-plus3"></i></button>';
	}
}

if ( ! function_exists( 'usk_add_cart_quantity_plus_minus' ) ) {
	function usk_add_cart_quantity_plus_minus() {

	echo '<style>
		input[type="number"]::-webkit-outer-spin-button,
		input[type="number"]::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		input[type="number"] {
			-moz-appearance: textfield; /* Firefox */
		}		
	</style>';

	wc_enqueue_js( "
		$(document).off('click.bdtQtyHandler'); // Remove previous handler
		$(document).on('click.bdtQtyHandler', 'button.bdt-add-to-cart-qty-plus, button.bdt-add-to-cart-qty-minus', function(e) {
			e.preventDefault();
			var qty = $(this).closest('form.cart').find('.qty');
			var val = parseFloat(qty.val()) || 0;
			var max = parseFloat(qty.attr('max')) || Infinity;
			var min = parseFloat(qty.attr('min')) || 0;
			var step = parseFloat(qty.attr( 'step' ));

			if ($(this).is('.bdt-add-to-cart-qty-plus')) {
				qty.val(Math.min(val + step, max)).trigger('change');
			} else {
				qty.val(Math.max(val - step, min)).trigger('change');
			}
		});
	");
	}
}

if ( ! function_exists( 'usk_setup_quantity_buttons' ) ) {
	function usk_setup_quantity_buttons() {
		if ( function_exists( 'is_product' ) ) {
			// Remove the default version
			remove_all_actions( 'woocommerce_before_quantity_input_field' );
			remove_all_actions( 'woocommerce_after_quantity_input_field' );
			remove_all_actions( 'woocommerce_before_single_product' );
		
			// Add our version
			add_action( 'woocommerce_before_quantity_input_field', 'usk_display_quantity_minus' );
			add_action( 'woocommerce_after_quantity_input_field', 'usk_display_quantity_plus' );
			add_action( 'woocommerce_after_single_product', 'usk_add_cart_quantity_plus_minus' );
		}		
	}
}
// End: Add to cart quantity buttons conversion
