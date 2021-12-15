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
 * @since    4.0, 5.4
 * @internal
 */
trait CollatorTrait
{
    /**
     * Add (append) an item to data array.
     *
     * @param  any $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _add($value): self
    {
        $this->readOnlyCheck();

        $this->data[] = $value;

        return $this;
    }

    /**
     * Set an item to data array by given key.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _set(int|string $key, $value): self
    {
        $this->readOnlyCheck();

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item from data array by given key.
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
     * Remove an item from data array by given key & fill ref if success.
     *
     * @param  int|string  $key
     * @param  any|null   &$value
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _remove(int|string $key, &$value = null): bool
    {
        $this->readOnlyCheck();

        if (array_key_exists($key, $this->data)) {
            $value = $this->data[$key];
            unset($this->data[$key]);

            return true;
        }

        return false;
    }

    /**
     * Remove an item from data array.
     *
     * @param  any              $value
     * @param  int|string|null &$key
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _removeValue($value, int|string &$key = null): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($value, $this->data, key: $key)) {
            unset($this->data[$key]);

            return true;
        }

        return false;
    }

    /**
     * Check whether given key set in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    private function _has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether given key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    private function _hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check whether given value exists in data array (with/without strict mode).
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    private function _hasValue($value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }

    /**
     * Check given key validity (for ListCollator & SetCollator only).
     *
     * @param  int|string|null $key
     * @param  bool            $all
     * @return void
     * @throws froq\collection\collator\CollatorException
     */
    private function _keyCheck(int|string|null $key, bool $all = false): void
    {
        if (!is_int($key)) {
            throw new CollatorException(
                $all ? 'Invalid data, data keys type must be int'
                     : 'Invalid key type, key type must be int'
            );
        }

        // Evaluates "'' < 0" true.
        if ($key < 0 && ($this instanceof ListCollator || $this instanceof SetCollator)) {
            throw new CollatorException(
                $all ? 'Invalid data, data keys must be sequential'
                     : 'Invalid key, key must be greater than or equal to 0'
            );
        }
    }
}
