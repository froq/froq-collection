<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides magic-access methods for the classes defining `set()`, `get(),
 * and `remove()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\AccessMagicTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.4
 */
trait AccessMagicTrait
{
    /** @magic */
    public function __isset(int|string $key): bool
    {
        return $this->get($key) !== null;
    }

    /** @magic */
    public function __set(int|string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /** @magic */
    public function &__get(int|string $key): mixed
    {
        return $this->get($key);
    }

    /** @magic */
    public function __unset(int|string $key): void
    {
        $this->remove($key);
    }
}
