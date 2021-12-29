<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\util\Arrays;

/**
 * Get Trait.
 *
 * Represents a trait that provides `get*()` utility methods for expected returns such as
 * int/bool/string/float for those classes define `get()` method and `getRandom()` method as well.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\GetTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.8 Separated from "AccessTrait" methods.
 */
trait GetTrait
{
    /**
     * Get a value as int.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return int
     * @since  4.2
     */
    public function getInt(int|string $key, $default = null): int
    {
        return (int) $this->get($key, $default);
    }

    /**
     * Get a value as float.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return float
     * @since  4.2
     */
    public function getFloat(int|string $key, $default = null): float
    {
        return (float) $this->get($key, $default);
    }

    /**
     * Get a value as string.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return string
     * @since  4.2
     */
    public function getString(int|string $key, $default = null): string
    {
        return (string) $this->get($key, $default);
    }

    /**
     * Get a value as bool.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return bool
     * @since  4.2
     */
    public function getBool(int|string $key, $default = null): bool
    {
        return (bool) $this->get($key, $default);
    }

    /**
     * Get a value as given type.
     *
     * @param  int|string $key
     * @param  string     $type
     * @param  mixed|null $default
     * @return mixed|null
     * @since  5.0
     */
    public function getAs(int|string $key, string $type, mixed $default = null)
    {
        return Arrays::getAs($this->data, $key, $type, $default);
    }

    /**
     * Get random item(s).
     *
     * @param  int        $limit
     * @param  mixed|null $default
     * @return mixed|null
     * @since  5.25
     */
    public function getRandom(int $limit = 1, mixed $default = null): mixed
    {
        return Arrays::getRandom($this->data, $limit, drop: $drop) ?? $default;
    }
}
