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
 * @package    Froq
 * @subpackage Froq\Collection
 * @object     Froq\Collection\Collection
 * @author     Kerem Güneş <k-gun@mail.com>
 * @since      1.0
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
            Arrays::set($this->data, $key, $value);
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
        return Arrays::get($this->data, $key, $valueDefault);
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
     * @inheritDoc Froq\Util\Interfaces\Arrayable
     */
    public function toArray(): array
    {
        return $this->getData();
    }

    /**
     * To object.
     * @return object
     */
    public function toObject(): object
    {
        return (object) $this->toArray();
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
     * @param  int|string|array $key
     * @param  any $value
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
     * Test (like JavaScript Array.some()).
     * @param  callable $fn
     * @return bool
     * @since  3.0
     */
    public function test(callable $fn): bool
    {
        return Arrays::test($this->data, $fn);
    }

    /**
     * Test all (like JavaScript Array.every()).
     * @param  callable $fn
     * @return bool
     * @since  3.0
     */
    public function testAll(callable $fn): bool
    {
        return Arrays::testAll($this->data, $fn);
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
        if ($func == null) {
            sort($this->data, $flags);
        } elseif ($func instanceof \Closure) {
            usort($this->data, $func);
        } elseif (is_string($func)) {
            if ($func[0] == 'u' && $ufunc == null) {
                throw new CollectionException("Second argument must be callable when usort,uasort,".
                    "uksort given");
            }
            $arguments = [&$this->data, $flags];
            if ($ufunc != null) {
                if (in_array($func, ['sort', 'asort', 'ksort'])) {
                    $func = 'u'. $func; // update to user function
                }
                $arguments[1] = $ufunc; // replace flags with ufunc
            }
            call_user_func_array($func, $arguments);
        }

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

    /**
     * Inherited methods from \Countable, \IteratorAggregate, \ArrayAccess
     */

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
}
