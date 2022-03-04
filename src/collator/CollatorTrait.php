<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

/**
 * Collator Trait.
 *
 * An trait, used in `froq\collection\collator` internally.
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
     * @param  mixed $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    protected function _add(mixed $value): self
    {
        $this->readOnlyCheck();

        $this->data[] = $value;

        return $this;
    }

    /**
     * Set a value to data array by given key.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    protected function _set(int|string $key, mixed $value): self
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
     * @param  mixed|null $default
     * @return mixed|null
     * @causes froq\common\exception\InvalidKeyException
     */
    protected function _get(int|string $key, mixed $default = null): mixed
    {
        $this->keyCheck($key);

        return $this->data[$key] ?? $default;
    }

    /**
     * Remove a value from data array by given key & fill ref if success.
     *
     * @param  int|string  $key
     * @param  mixed|null &$value
     * @param  bool        $reset
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    protected function _remove(int|string $key, mixed &$value = null, bool $reset = false): bool
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
     * @param  mixed            $value
     * @param  int|string|null &$key
     * @param  bool             $reset
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    protected function _removeValue(mixed $value, int|string &$key = null, bool $reset = false): bool
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
     * @param  mixed      $value
     * @return bool
     * @since  5.17
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    protected function _replace(int|string $key, mixed $value): bool
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
     * @param  mixed            $oldValue
     * @param  mixed            $newValue
     * @param  int|string|null &$key
     * @return bool
     * @since  5.17
     * @causes froq\common\exception\ReadOnlyException
     */
    protected function _replaceValue(mixed $oldValue, mixed $newValue, int|string &$key = null): bool
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
    protected function _has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether given key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    protected function _hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check whether given value exists in data array with strict mode.
     *
     * @param  mixed            $value
     * @param  int|string|null &$key
     * @return bool
     */
    protected function _hasValue(mixed $value, int|string &$key = null): bool
    {
        return array_value_exists($value, $this->data, key: $key);
    }

    /**
     * Reset data array keys.
     *
     * @return void
     */
    protected function resetKeys(): void
    {
        $this->data = array_values($this->data);
    }
}
