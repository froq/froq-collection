<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AccessException;

/**
 * Access Magic Trait.
 *
 * Represents an access magic trait that used in `froq\collection` internally for stack and collection objects.
 *
 * @package  froq\collection
 * @object   froq\collection\AccessMagicTrait
 * @author   Kerem Güneş <k-gun@mail.com>
 * @since    5.0
 * @internal
 */
trait AccessMagicTrait
{
    /**
     * Magic - set.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return void
     */
    public final function __set($key, $value)
    {
        $this->set($key, $value);
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
}