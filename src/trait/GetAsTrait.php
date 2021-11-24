<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Get-as Trait.
 *
 * Represents a trait that provides `getAs()` and other utility methods for expected returns
 * such as int/bool/string/float for those classes define `get()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\GetAsTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.8 Separated from "AccessTrait" methods.
 */
trait GetAsTrait
{
    /**
     * Get a value as given type.
     *
     * @param  int|string $key
     * @param  string     $type
     * @param  any|null   $default
     * @return any
     * @since  5.0
     */
    public final function getAs(int|string $key, string $type, $default = null)
    {
        $value = $this->get($key, $default);
        settype($value, $type);

        return $value;
    }

    /**
     * Get a value as int.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return int
     * @since  4.2
     */
    public final function getInt(int|string $key, $default = null): int
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
    public final function getFloat(int|string $key, $default = null): float
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
    public final function getString(int|string $key, $default = null): string
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
    public final function getBool(int|string $key, $default = null): bool
    {
        return (bool) $this->get($key, $default);
    }
}
