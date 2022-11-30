<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `has()`, `hasKey()` and `hasValue()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\HasTrait
 * @author  Kerem Güneş
 * @since   5.15
 */
trait HasTrait
{
    /**
     * Check whether given key set in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    public function has(int|string $key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Check whether given key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    public function hasKey(int|string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Check whether given value exists in data array.
     *
     * @param  mixed $value
     * @param  bool  $strict
     * @return bool
     */
    public function hasValue(mixed $value, bool $strict = true): bool
    {
        return array_value_exists($value, $this->data, $strict);
    }
}
