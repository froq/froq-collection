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
 * Represents a trait that defines related methods for the classes implementing `ArrayAccess`
 * interface and contains `set()`, `get(), `remove()` and `count()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AccessTrait
 * @author  Kerem Güneş
 * @since   4.0, 5.4 Moved as "trait.AccessTrait" from "AccessTrait".
 */
trait AccessTrait
{
    /** @inheritDoc ArrayAccess */
    public function offsetExists(mixed $key): bool
    {
        if (is_object($key)) {
            $key = get_object_id($key);
        }

        return $this->get($key) !== null;
    }

    /** @inheritDoc ArrayAccess */
    public function offsetSet(mixed $key, mixed $value): void
    {
        if (is_object($key)) {
            $key = get_object_id($key);
        }

        // For calls like `items[] = item`.
        $key ??= $this->count();

        $this->set($key, $value);
    }

    /** @inheritDoc ArrayAccess */
    public function offsetGet(mixed $key): mixed
    {
        if (is_object($key)) {
            $key = get_object_id($key);
        }

        return $this->get($key);
    }

    /** @inheritDoc ArrayAccess */
    public function offsetUnset(mixed $key): void
    {
        if (is_object($key)) {
            $key = get_object_id($key);
        }

        $this->remove($key);
    }
}
