<?php

/**
 * Checkout Page
 *
 * This template can be overridden by copying it to
 * yourtheme/woocommerce/checkout/checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;

use UltimateStoreKit\Builder\Builder_Integration;

get_header('shop');

if (class_exists('Elementor\Plugin')) {
?>
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
		<?php echo Elementor\Plugin::instance()->frontend->get_builder_content(Builder_Integration::instance()->current_template_id, false); ?>
	</form>
<?php
}

get_footer('shop');
?>