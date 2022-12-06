<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\collector;

use froq\collection\trait\ArrayTrait;
use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Iteratable, IteratableReverse};
use froq\util\Util;

/**
 * Abstract collector class.
 *
 * @package froq\collection\collector
 * @class   froq\collection\collector\AbstractCollector
 * @author  Kerem Güneş
 * @since   5.17, 6.0
 */
abstract class AbstractCollector implements Arrayable, Objectable, Listable, Jsonable, Iteratable, IteratableReverse,
    \Iterator, \Countable, \JsonSerializable
{
    use ArrayTrait;

    /** Data. */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable $data
     */
    public function __construct(iterable $data = [])
    {
        if ($data) {
            if (is_iterator($data)) {
                $data = Util::makeArray($data, deep: false);
            }

            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }
    }

    /**
     * Add (append) a value to data array.
     *
     * @param  mixed $value
     * @return self
     */
    protected function _add(mixed $value): self
    {
        $this->data[] = $value;

        return $this;
    }

    /**
     * Set a value to data array by given key.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     */
    protected function _set(int|string $key, mixed $value): self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get a value from data array by given key.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed|null
     */
    protected function &_get(int|string $key, mixed $default = null): mixed
    {
        $value =& $this->data[$key] ?? $default;

        return $value;
    }

    /**
     * Remove a value from data array by given key.
     *
     * @param  int|string $key
     * @param  bool       $reset
     * @return bool
     */
    protected function _remove(int|string $key, bool $reset = false): bool
    {
        if (array_key_exists($key, $this->data)) {
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
     * @param  mixed $value
     * @param  bool  $reset
     * @return bool
     */
    protected function _removeValue(mixed $value, bool $reset = false): bool
    {
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
     */
    protected function _replace(int|string $key, mixed $value): bool
    {
        if (array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;

            return true;
        }

        return false;
    }

    /**
     * Replace a value with given new value if value exists.
     *
     * @param  mixed $oldValue
     * @param  mixed $newValue
     * @return bool
     */
    protected function _replaceValue(mixed $oldValue, mixed $newValue): bool
    {
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
