<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
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
 * @author   Kerem Güneş
 * @since    4.0
 * @internal
 */
trait AccessTrait
{
    /** @var array */
    private static array $__READ_ONLY_STATES;

    /**
     * Set/get read-only state.
     *
     * @param  bool|null $state
     * @return bool|null
     */
    public final function readOnly(bool $state = null): bool|null
    {
        $id = spl_object_id($this);

        if ($state !== null) {
            self::$__READ_ONLY_STATES[$id] = $state;
        }

        return self::$__READ_ONLY_STATES[$id] ?? null;
    }

    /**
     * Check read-only state, throw an `AccessException` if object is read-only.
     *
     * @return void
     * @throws froq\collection\AccessException
     */
    public final function readOnlyCheck(): void
    {
        $this->readOnly() && throw new AccessException(
            'Cannot modify read-only object ' . static::class
        );
    }

    /**
     * Lock, read-only state as true.
     *
     * @return static
     */
    public final function lock(): static
    {
        $this->readOnly(true);

        return $this;
    }

    /**
     * Unlock, read-only state as true.
     *
     * @return static
     */
    public final function unlock(): static
    {
        $this->readOnly(false);

        return $this;
    }

    /**
     * Get a value as given type.
     *
     * @param  int|string $key
     * @param  string     $type
     * @return any
     * @since  5.0
     */
    public final function getAs(int|string $key, string $type)
    {
        $value = $this->get($key);
        settype($value, $type);

        return $value;
    }

    /**
     * Get a value as int.
     *
     * @param  int|string $key
     * @return int
     * @since  4.2
     */
    public final function getInt(int|string $key): int
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
    public final function getFloat(int|string $key): float
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
    public final function getString(int|string $key): string
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
    public final function getBool(int|string $key): bool
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
