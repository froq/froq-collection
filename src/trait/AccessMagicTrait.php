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
 * Represents an access magic trait that provides some utility methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\AccessMagicTrait
 * @author  Kerem Güneş
 * @since   5.0, 5.4 Moved as trait.AccessMagicTrait from AccessMagicTrait.
 */
trait AccessMagicTrait
{
    /**
     * Magic - isset.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function __isset(int|string $key): bool
    {
        return $this->has($key);
    }

    /**
     * Magic - set.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return void
     */
    public final function __set(int|string $key, mixed $value): void
    {
        $this->set($key, $value);
    }

    /**
     * Magic - get.
     *
     * @param  int|string $key
     * @return mixed
     */
    public final function __get(int|string $key): mixed
    {
        return $this->get($key);
    }

    /**
     * Magic - unset.
     *
     * @param  int|string $key
     * @return void
     */
    public final function __unset(int|string $key): void
    {
        $this->remove($key);
    }
}
