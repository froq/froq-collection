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

namespace Froq\Collection;

use Froq\Util\Arrays;
use Froq\Util\Interfaces\Arrayable;

/**
 * @package     Froq
 * @subpackage  Froq\Collection
 * @object      Froq\Collection\Collection
 * @author      Kerem Güneş <k-gun@mail.com>
 */
class Collection implements Arrayable, \ArrayAccess
{
    /**
     * Data.
     * @var array
     */
    protected $data = [];

    /**
     * Constructor.
     * @param array $data
     */
    public function __construct(array $data = null)
    {
        $this->setData($data ?? []);
    }

    /**
     * Set magic.
     * @param  int|string $key
     * @param  any        $value
     * @return void
     */
    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Get magic.
     * @param  int|string $key
     * @return any
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Isset magic.
     * @param  int|string $key
     * @return bool
     */
    public function __isset($key)
    {
        return $this->isset($key);
    }

    /**
     * Unset magic.
     * @param  int|string $key
     * @return void
     */
    public function __unset($key)
    {
        $this->unset($key);
    }

    /**
     * Set data.
     * @param  array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * Get data.
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public function set($key, $value): self
    {
        if ($key === null) { // $x[] = ..
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Get.
     * @param  int|string $key
     * @param  any        $valueDefault
     * @return any
     */
    public function get($key, $valueDefault = null)
    {
        return $this->dig($key, $valueDefault);
    }

    /**
     * Is set.
     * @param  int|string $key
     * @return bool
     */
    public function isset($key): bool
    {
        return array_key_exists($key, $this->data);
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
     * Offset set.
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function offsetSet($key, $value): self
    {
        return $this->set($key, $value);
    }

    /**
     * Offset get.
     * @param  int|string $key
     * @return any
     */
    public final function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Offset unset.
     * @param  int|string $key
     * @return void
     */
    public final function offsetUnset($key): void
    {
        $this->unset($key);
    }

    /**
     * Offset exists.
     * @param  int|string $key
     * @return bool
     */
    public final function offsetExists($key): bool
    {
        return $this->isset($key);
    }

    /**
     * @inheritDoc \Countable
     */
    public final function count(): int
    {
        return count($this->data);
    }

    /**
     * @inheritDoc \IteratorAggregate
     */
    public final function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * To array.
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Dig.
     * @param  int|string $key
     * @param  any        $valueDefault
     * @return any
     */
    public final function dig($key, $valueDefault = null)
    {
        return Arrays::dig($this->data, $key, $valueDefault);
    }

    /**
     * Empty.
     * @return void
     */
    public final function empty(): void
    {
        $this->data = [];
    }

    /**
     * Is empty.
     * @return bool
     */
    public final function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Keys.
     * @return array
     */
    public final function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Values.
     * @return array
     */
    public final function values(): array
    {
        return array_values($this->data);
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
    public function hasValue($value, bool $strict = false): bool
    {
        return in_array($value, $this->data, $strict);
    }

    /**
     * Pick.
     * @param  int|string $key
     * @param  any        $valueDefault
     * @return any
     */
    public function pick($key, $valueDefault = null)
    {
        return Arrays::pick($this->data, $key, $valueDefault);
    }

    /**
     * Pick all.
     * @param  array  $keys
     * @param  any    $valueDefault
     * @return any
     */
    public function pickAll(array $keys, $valueDefault = null): array
    {
        return Arrays::pickAll($this->data, $keys, $valueDefault);
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return void
     */
    public function remove($key): void
    {
        $this->unset($key);
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
        if ($keys != null) {
            $return = [];
            foreach ($keys as $key) {
                $return[$key] = $this->get($key);
            }
        } else {
            $return = $this->data;
        }

        return $return;
    }

    /**
     * Item first.
     * @return any
     */
    public function itemFirst()
    {
        return Arrays::first($this->data);
    }

    /**
     * Item last.
     * @return any
     */
    public function itemLast()
    {
        return Arrays::last($this->data);
    }
}
