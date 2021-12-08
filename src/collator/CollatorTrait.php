<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\util\Arrays;

/**
 * Collator Trait.
 *
 * Represents a trait entity that used in `froq\collection\collator` internally to avoid code repetition.
 *
 * @package  froq\collection\collator
 * @object   froq\collection\collator\CollatorTrait
 * @author   Kerem Güneş
 * @since    4.0, 5.4 Moved as stack => collator.
 * @internal
 */
trait CollatorTrait
{
    /**
     * Add (append) an item to data array with given key/index.
     *
     * @param  int|string $key
     * @param  any        $value
     * @param  bool       $flat
     * @return self
     */
    private function _add(int|string $key, $value, bool $flat = true): self
    {
        $this->readOnlyCheck();

        if (isset($this->data[$key])) {
            $this->data[$key] = $flat
                ? Arrays::flat([$this->data[$key], $value])
                : Arrays::merge((array) $this->data[$key], $value);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Put an item to data array with given key/index.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    private function _set(int|string $key, $value): self
    {
        $this->readOnlyCheck();

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item from data array by given key/index.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return any|null
     */
    private function _get(int|string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Remove an item from data array by given key/index.
     *
     * @param  int|string $key
     * @return bool
     */
    private function _remove(int|string $key): bool
    {
        $this->readOnlyCheck();

        if (isset($this->data[$key])) {
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    /**
     * Check whether an item was set in data array with given key/index.
     *
     * @param  int|string $key
     * @return bool
     */
    private function _has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether given key/index exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    private function _hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check with/without strict mode whether data array has given value.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    private function _hasValue($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }
}
