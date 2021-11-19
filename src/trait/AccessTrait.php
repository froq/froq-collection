<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Access Trait.
 *
 * Represents an access trait that provides some utility methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AccessTrait
 * @author  Kerem Güneş
 * @since   4.0, 5.4 Moved as trait.AccessTrait from AccessTrait.
 */
trait AccessTrait
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

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetSet($key, $value)
    {
        // For "items[] = item" calls.
        $key ??= $this->count();

        return $this->set($key, $value);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetUnset($key)
    {
        return $this->remove($key);
    }
}
