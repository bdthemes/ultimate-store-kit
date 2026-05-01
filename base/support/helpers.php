<?php

use UltimateStoreKit\Base\Support\Optional;

if (!function_exists('ultimate_store_kit_dd')) {

    /**
     * dump & die.
     */
    function ultimate_store_kit_dd($x) {
        echo '<pre>';
        if (is_array($x) || is_object($x)) {
            // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_print_r
            print_r($x);
        } else {
            echo wp_kses_post($x);
        }
        echo '</pre>';
        exit;
    }
}

if (! function_exists('ultimate_store_kit_optional')) {
    /**
     * Provide access to optional objects.
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


if (! function_exists('ultimate_store_kit_array_except')) {
    /**
     * Provide access to optional objects.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function ultimate_store_kit_array_except($array, $keys) {

        $original = &$array;

        $keys = (array) $keys;

        if (count($keys) === 0) {
            return;
        }

        foreach ($keys as $key) {
            // if the exact key exists in the top-level, remove it
            if (array_key_exists($key, $array)) {
                unset($array[$key]);

                continue;
            }

            $parts = explode('.', $key);

            // clean up before each pass
            $array = &$original;

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                } else {
                    continue 2;
                }
            }

            unset($array[array_shift($parts)]);
        }

        return $array;
    }
}
