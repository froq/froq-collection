<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Access Magic Trait.
 *
 * Represents a trait that provides magic-access methods and contains `set()`, `get(), `remove()`
 * and `count()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AccessMagicTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.4 Moved as trait.AccessMagicTrait from AccessMagicTrait.
 */
trait AccessMagicTrait
{
    /** @magic __isset() */
    public function __isset(int|string $key): bool
    {
        return $this->get($key) !== null;
    }

    /** @magic __set() */
    public function __set(int|string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /** @magic __get() */
    public function __get(int|string $key): mixed
    {
        return $this->get($key);
    }

    /** @magic __unset() */
    public function __unset(int|string $key): void
    {
        $this->remove($key);
    }
}
