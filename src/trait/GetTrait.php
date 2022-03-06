<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Get Trait.
 *
 * A trait, provides `get*()` methods for desired returns such as int, bool
 * etc. for the classes defining `get()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\GetTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.8
 */
trait GetTrait
{
    /**
     * Get a value as int.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return int
     * @since  4.2
     */
    public function getInt(int|string $key, mixed $default = null): int
    {
        return (int) $this->get($key, $default);
    }

    /**
     * Get a value as float.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return float
     * @since  4.2
     */
    public function getFloat(int|string $key, mixed $default = null): float
    {
        return (float) $this->get($key, $default);
    }

    /**
     * Get a value as string.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return string
     * @since  4.2
     */
    public function getString(int|string $key, mixed $default = null): string
    {
        return (string) $this->get($key, $default);
    }

    /**
     * Get a value as bool.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return bool
     * @since  4.2
     */
    public function getBool(int|string $key, mixed $default = null): bool
    {
        return (bool) $this->get($key, $default);
    }

    /**
     * Get a value as array.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return array
     * @since  6.0
     */
    public function getArray(int|string $key, mixed $default = null): array
    {
        return (array) $this->get($key, $default);
    }

    /**
     * Get a value as object.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return object
     * @since  6.0
     */
    public function getObject(int|string $key, mixed $default = null): object
    {
        return (object) $this->get($key, $default);
    }
}
