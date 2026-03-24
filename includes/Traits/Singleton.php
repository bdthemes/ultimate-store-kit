<?php

namespace UltimateStoreKit\Traits;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Singleton Trait
 *
 * Provides singleton functionality to classes
 */
trait Singleton {
    /**
     * Instance of this class
     *
     * @var static
     */
    protected static $instance = null;

    /**
     * Get instance of this class
     *
     * @return static
     */
    public static function get_instance() {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Prevent cloning of the instance
     *
     * @return void
     */
    private function __clone() {
    }

    /**
     * Prevent unserializing of the instance
     *
     * @throws \Exception When attempting to unserialize
     * @return void
     */
    public function __wakeup() {
        throw new \Exception('Cannot unserialize singleton');
    }
}
