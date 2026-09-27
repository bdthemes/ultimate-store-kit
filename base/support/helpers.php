<?php

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals -- usk_ / BDTUSK_ / ultimate-store-kit- are this plugin's established public prefixes. Ultimate Store Kit Pro calls into these names, as does third-party integration code, so renaming them is a breaking change. Plugin Check only recognises prefixes derived verbatim from the slug and so reports them as unprefixed.

use UltimateStoreKit\Base\Support\Optional;

if (! function_exists('ultimate_store_kit_optional')) {
    /**
     * Provide access to optional objects.
     *
     * Named ultimate_store_kit_optional() rather than optional(): the unprefixed name is the
     * Laravel helper, which any plugin bundling illuminate/support also declares.
     * Behind a function_exists() guard the first declaration wins, so an
     * unprefixed version would silently hand this plugin a foreign Optional class.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function ultimate_store_kit_optional($value = null, ?callable $callback = null) {
        if (is_null($callback)) {
            return new Optional($value);
        } elseif (! is_null($value)) {
            return $callback($value);
        }
    }
}
