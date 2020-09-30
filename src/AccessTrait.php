<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AccessException;

/**
 * Access Trait.
 *
 * Represents an access trait that used in `froq\collection` internally for stacks and collection
 * objects.
 *
 * @package  froq\collection
 * @object   froq\collection\AccessTrait
 * @author   Kerem Güneş <k-gun@mail.com>
 * @since    4.0
 * @internal Used in froq\collection only.
 */
trait AccessTrait
{
    /**
     * Read-only states.
     * @var array
     */
    private static array $__readOnlyStates;

    /**
     * Read-only setter/getter.
     * @param  bool|null $state
     * @return ?bool
     */
    public final function readOnly(bool $state = null): ?bool
    {
        $id = spl_object_id($this);

        // Set state for once, so it cannot be modified anymore calling readOnly().
        if (isset($state) && !isset(self::$__readOnlyStates[$id])) {
            self::$__readOnlyStates[$id] = $state;
        }

        return self::$__readOnlyStates[$id] ?? null;
    }

    /**
     * Read-only checker.
     * @return void
     * @throws froq\stack\StackException
     */
    public final function readOnlyCheck(): void
    {
        if ($this->readOnly()) {
            throw new AccessException('Cannot modify read-only "%s" object', [static::class]);
        }
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Get.
     * @param  int|string $key
     * @return any
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Isset.
     * @param  int|string $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Unset.
     * @param  int|string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->remove($key);
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
