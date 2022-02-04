<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\common\exception\InvalidKeyException;

/**
 * Collator Trait.
 *
 * Represents a trait entity that used in `froq\collection\collator` internally
 * to avoid code repetition.
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
     * Add (append) a value to data array.
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
     * Set a value to data array by given key.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    private function _set(int|string $key, $value): self
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get a value from data array by given key.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return any|null
     * @causes froq\common\exception\InvalidKeyException
     */
    private function _get(int|string $key, $default = null)
    {
        $this->keyCheck($key);

        return $this->data[$key] ?? $default;
    }

    /**
     * Remove a value from data array by given key & fill ref if success.
     *
     * @param  int|string  $key
     * @param  any|null   &$value
     * @param  bool        $reset
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    private function _remove(int|string $key, &$value = null, bool $reset = false): bool
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

        if (array_key_exists($key, $this->data)) {
            $value = $this->data[$key];
            unset($this->data[$key]);

            // Re-index.
            $reset && $this->resetKeys();

            return true;
        }

        return false;
    }

    /**
     * Remove a value from data array.
     *
     * @param  any              $value
     * @param  int|string|null &$key
     * @param  bool             $reset
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _removeValue($value, int|string &$key = null, bool $reset = false): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($value, $this->data, key: $key)) {
            unset($this->data[$key]);

            // Re-index.
            $reset && $this->resetKeys();

            return true;
        }

        return false;
    }

    /**
     * Replace a value by given key if key exists.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return bool
     * @since  5.17
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    private function _replace(int|string $key, $value): bool
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

        if (array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Replace a value with given new value if value exists.
     *
     * @param  any              $oldValue
     * @param  any              $newValue
     * @param  int|string|null &$key
     * @return bool
     * @since  5.17
     * @causes froq\common\exception\ReadOnlyException
     */
    private function _replaceValue($oldValue, $newValue, int|string &$key = null): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldValue, $this->data, key: $key)) {
            $this->data[$key] = $newValue;

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
     * Check whether given value exists in data array with strict mode.
     *
     * @param  any              $value
     * @param  int|string|null &$key
     * @return bool
     */
    private function _hasValue($value, int|string &$key = null): bool
    {
        return array_value_exists($value, $this->data, key: $key);
    }

    /**
     * Reset data array keys.
     *
     * @return void
     */
    private function resetKeys(): void
    {
        $this->data = array_values($this->data);
    }

    /**
     * Check given offset validity.
     *
     * @param  mixed $offset
     * @param  bool  $all
     * @return void
     * @throws froq\common\exception\InvalidKeyException
     */
    public final function keyCheck(mixed $offset, bool $all = false): void
    {
        switch (true) {
            case ($this instanceof ArrayCollator):
                is_int($offset) || is_string($offset) || throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be int|string'
                         : 'Invalid key type, key type must be int|string'
                );
                break;
            case ($this instanceof MapCollator):
                is_string($offset) || throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be string'
                         : 'Invalid key type, key type must be string'
                );
                break;
            case ($this instanceof SetCollator):
                is_int($offset) || throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be int'
                         : 'Invalid key type, key type must be int'
                );

                // Note: evaluates "'' < 0" true.
                if ($offset < 0) throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be sequential'
                         : 'Invalid key, key must be greater than or equal to 0'
                );
                break;
            case ($this instanceof ListCollator):
                is_int($offset) || throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be int'
                         : 'Invalid key type, key type must be int'
                );

                // Note: evaluates "'' < 0" true.
                if ($offset < 0) throw new InvalidKeyException(
                    $all ? 'Invalid data, data keys must be sequential'
                         : 'Invalid key, key must be greater than or equal to 0'
                );
        }
    }
}
