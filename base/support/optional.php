<?php

namespace UltimateStoreKit\Base\Support;

use ArrayAccess;
use ArrayObject;

class Optional implements ArrayAccess {
    /**
     * The underlying object.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Create a new optional instance.
     *
     * @param  mixed  $value
     * @return void
     */
    public function __construct($value) {
        $this->value = $value;
    }

    /**
     * Dynamically access a property on the underlying object.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key) {
        if (is_object($this->value)) {
            return isset($this->value->{$key}) ? $this->value->{$key} : null;
        }
    }

    /**
     * Dynamically check a property exists on the underlying object.
     *
     * @param  mixed  $name
     * @return bool
     */
    public function __isset($name) {
        if (is_object($this->value)) {
            return isset($this->value->{$name});
        }

        if (is_array($this->value) || $this->value instanceof ArrayObject) {
            return isset($this->value[$name]);
        }

        return false;
    }

    /**
     * Determine if an item exists at an offset.
     *
     * @param  mixed  $key
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($key): bool {
        return $this->accessible($this->value) && $this->exists($this->value, $key);
    }

    protected function accessible($value) {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    protected function exists($array, $key) {
        if ($array instanceof ArrayAccess) {
            return $array->offsetExists($key);
        }

        return array_key_exists($key, $array);
    }

    /**
     * Get an item at a given offset.
     *
     * @param  mixed  $key
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($key) {
        return $this->get($this->value, $key);
    }


    protected function get($array, $key, $default = null) {
        if (!$this->accessible($array)) {
            return $this->value($default);
        }

        if (is_null($key)) {
            return $array;
        }

        if ($this->exists($array, $key)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return isset($array[$key]) ? $array[$key] : $this->value($default);
        }

        foreach (explode('.', $key) as $segment) {
            if ($this->accessible($array) && $this->exists($array, $segment)) {
                $array = $array[$segment];
            } else {
                return $this->value($default);
            }
        }

        return $array;
    }

    protected function value($value) {
        return $value instanceof \Closure ? $value() : $value;
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value): void {
        if ($this->accessible($this->value)) {
            $this->value[$key] = $value;
        }
    }

    /**
     * Unset the item at a given offset.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key): void {
        if ($this->accessible($this->value)) {
            unset($this->value[$key]);
        }
    }
}
