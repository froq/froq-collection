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
 * Represents an trait that provides some utility methods for those classes define `has()`,
 * `set()`, `get()` and `remove()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AccessTrait
 * @author  Kerem Güneş
 * @since   4.0, 5.4 Moved as "trait.AccessTrait" from "AccessTrait".
 */
trait AccessTrait
{
    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetExists(mixed $key): bool
    {
        return $this->get($key) !== null;
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetSet(mixed $key, mixed $value): void
    {
        // For "items[] = item" calls.
        $key ??= $this->count();

        $this->set($key, $value);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetGet(mixed $key): mixed
    {
        return $this->get($key);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetUnset(mixed $key): void
    {
        $this->remove($key);
    }
}
