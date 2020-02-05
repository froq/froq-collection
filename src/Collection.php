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

use froq\util\Arrays;
use froq\collection\AbstractCollection;
use ArrayAccess;

/**
 * Collection.
 * @package froq\collection
 * @object  froq\collection\Collection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   1.0
 */
class Collection extends AbstractCollection implements ArrayAccess
{
    /**
     * Constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
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
        return $this->isset($key);
    }

    /**
     * Unset.
     * @param  int|string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->unset($key);
    }

    /**
     * Set.
     * @param  int|string|null $key
     * @param  any             $value
     * @return self
     */
    public function set($key, $value): self
    {
        if ($key === null) { // eg: $x[] = ..
            $this->data[] = $value;
        } else {
            Arrays::set($this->data, $key, $value);
        }

        return $this;
    }

    /**
     * Set all.
     * @param  array $data
     * @return self
     * @since  4.0
     */
    public function setAll(array $data): self
    {
        Arrays::setAll($this->data, $data);
    }

    /**
     * Get.
     * @param  int|string $key
     * @param  any        $valueDefault
     * @return any
     */
    public function get($key, $valueDefault = null)
    {
        return Arrays::get($this->data, $key, $valueDefault);
    }

    /**
     * Get all.
     * @param  array $keys
     * @param  any   $valueDefault
     * @return array
     */
    public function getAll($keys, $valueDefault = null): array
    {
        return Arrays::getAll($this->data, $keys, $valueDefault);
    }

    /**
     * Isset.
     * @param  int|string $key
     * @return bool
     */
    public function isset($key): bool
    {
        return isset($this->data[$key]);
    }

    /**
     * Unset.
     * @param  int|string $key
     * @return void
     */
    public function unset($key): void
    {
        unset($this->data[$key]);
    }

    /**
     * Check.
     * @param  int|string $key
     * @return bool
     */
    public function has($key): bool
    {
        return $this->isset($key);
    }

    /**
     * Has key.
     * @param  int|string $key
     * @return bool
     */
    public function hasKey($key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
    }

    /**
     * Pull.
     * @param  int|string $key
     * @param  any        $valueDefault
     * @return any
     * @since  3.0
     */
    public function pull($key, $valueDefault = null)
    {
        return Arrays::pull($this->data, $key, $valueDefault);
    }

    /**
     * Pull all.
     * @param  array  $keys
     * @param  any    $valueDefault
     * @return any
     * @since  3.0
     */
    public function pullAll(array $keys, $valueDefault = null): array
    {
        return Arrays::pullAll($this->data, $keys, $valueDefault);
    }

    /**
     * Add.
     * @param  int|string|array|null $key
     * @param  any                   $value
     * @return self
     * @since  3.0
     */
    public function add($key, $value): self
    {
        if (is_array($key)) {
            @ [$key, $value] = $key;
        }

        return $this->set($key, $value);
    }

    /**
     * Remove.
     * @param  int|string|array $key
     * @return self
     */
    public function remove($key): self
    {
        foreach ((array) $key as $key) {
            $this->unset($key);
        }

        return $this;
    }

    /**
     * Pop.
     * @return any
     * @since  4.0
     */
    public function pop()
    {
        return array_pop($this->data);
    }

    /**
     * Unpop.
     * @param  array<int|string, any> $data
     * @return self
     * @since  4.0
     */
    function unpop(array $data): self
    {
        foreach ($data as $key => $value) {
            // Drop olds, so prevent in-place replace.
            if (isset($this->data[$key])) {
                unset($this->data[$key]);
            }
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Shift.
     * @return any
     * @since  4.0
     */
    public function shift()
    {
        return array_shift($this->data);
    }

    /**
     * Unshift.
     * @param  array<int|string, any> $data
     * @return self
     * @since  4.0
     */
    public function unshift(array $data): self
    {
        $this->data = $data + $this->data;

        return $this;
    }

    /**
     * Reverse.
     * @param  bool $preserveKeys
     * @return self
     * @since  4.0
     */
    public function reverse(bool $preserveKeys = false): self
    {
        $this->data = array_reverse($this->data, $preserveKeys);

        return $this;
    }

    /**
     * Test (like JavaScript Array.some()).
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function test(callable $func): bool
    {
        return Arrays::test($this->data, $func);
    }

    /**
     * Test all (like JavaScript Array.every()).
     * @param  callable $func
     * @return bool
     * @since  3.0
     */
    public function testAll(callable $func): bool
    {
        return Arrays::testAll($this->data, $func);
    }

    /**
     * Sort.
     * @param  callable|null $func
     * @param  callable|null $ufunc
     * @param  int           $flags
     * @return self
     */
    public function sort(callable $func = null, callable $ufunc = null, int $flags = 0): self
    {
        Arrays::sort($this->data, $func, $ufunc, $flags);

        return $this;
    }

    /**
     * Item.
     * @param  int|string $key
     * @return any
     */
    public function item($key)
    {
        return $this->get($key);
    }

    /**
     * Items.
     * @param  array|null $keys
     * @return array
     */
    public function items(array $keys = null): array
    {
        if ($keys == null) {
            return $this->data;
        }

        $items = [];
        foreach ($keys as $key) {
            $items[$key] = $this->get($key);
        }
        return $items;
    }

    /**
     * First.
     * @return any|null
     * @since  4.0
     */
    public function first()
    {
        $key = $this->firstKey();

        return ($key !== null) ?  $this->data[$key] : null;
    }

    /**
     * First key.
     * @return int|string
     * @since  4.0
     */
    public function firstKey()
    {
        return array_key_first($this->data);
    }

    /**
     * Last.
     * @return any|null
     * @since  4.0
     */
    public function last()
    {
        $key = $this->lastKey();

        return ($key !== null) ? $this->data[$key] : null;
    }

    /**
     * Last key.
     * @return int|string
     * @since  4.0
     */
    public function lastKey()
    {
        return array_key_last($this->data);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetSet($key, $value)
    {
        $this->set($key, $value);
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
        $this->unset($key);
    }

    /**
     * @inheritDoc ArrayAccess
     */
    public final function offsetExists($key)
    {
        return $this->isset($key);
    }
}
