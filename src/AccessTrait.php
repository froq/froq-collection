<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AccessException;

/**
 * Access Trait.
 *
 * Represents an access trait that used in `froq\collection` internally for stack and collection objects.
 *
 * @package  froq\collection
 * @object   froq\collection\AccessTrait
 * @author   Kerem Güneş <k-gun@mail.com>
 * @since    4.0
 * @internal Used in froq\collection only.
 */
trait AccessTrait
{
    /** @var array */
    private static array $__readOnlyStates;

    /**
     * Set/get read-only state.
     *
     * @param  bool|null $state
     * @return ?bool
     */
    public final function readOnly(bool $state = null): ?bool
    {
        $id = spl_object_id($this);

        // Set state for once, so it cannot be modified calling readOnly() anymore.
        if (isset($state) && !isset(self::$__readOnlyStates[$id])) {
            self::$__readOnlyStates[$id] = $state;
        }

        return self::$__readOnlyStates[$id] ?? null;
    }

    /**
     * Check read-only state, throw an `AccessException` if object is read-only.
     *
     * @return void
     * @throws froq\stack\AccessException
     */
    public final function readOnlyCheck(): void
    {
        if ($this->readOnly()) {
            throw new AccessException("Cannot modify read-only '%s' object", static::class);
        }
    }

    /**
     * Magic - set.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Magic - get.
     *
     * @param  int|string $key
     * @return any
     */
    public final function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Magic - isset.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Magic - unset.
     *
     * @param  int|string $key
     * @return void
     */
    public final function __unset($key)
    {
        $this->remove($key);
    }

    /**
     * Get a value as int.
     *
     * @param  int|string $key
     * @return int
     * @since  4.2
     */
    public final function getInt($key): int
    {
        return (int) $this->get($key);
    }

    /**
     * Get a value as float.
     *
     * @param  int|string $key
     * @return float
     * @since  4.2
     */
    public final function getFloat($key): float
    {
        return (float) $this->get($key);
    }

    /**
     * Get a value as string.
     *
     * @param  int|string $key
     * @return string
     * @since  4.2
     */
    public final function getString($key): string
    {
        return (string) $this->get($key);
    }

    /**
     * Get a value as bool.
     *
     * @param  int|string $key
     * @return bool
     * @since  4.2
     */
    public final function getBool($key): bool
    {
        return (bool) $this->get($key);
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
