<?php

use UltimateStoreKit\Base\Support\Optional;

if (!function_exists('dd')) {

    /**
     * dump & die.
     */
    function dd($x) {
        echo '<pre>';
        if (is_array($x) || is_object($x)) {
            print_r($x);
        } else {
            echo wp_kses_post($x);
        }
        echo '</pre>';
        exit;
    }
}

if (! function_exists('optional')) {
    /**
     * Provide access to optional objects.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function optional($value = null, callable $callback = null) {
        if (is_null($callback)) {
            return new Optional($value);
        } elseif (! is_null($value)) {
            return $callback($value);
        }
    }
}


if (! function_exists('array_except')) {
    /**
     * Provide access to optional objects.
     *
     * @param  mixed  $value
     * @param  callable|null  $callback
     * @return mixed
     */
    function array_except($array, $keys) {

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
