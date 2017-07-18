<?php
/**
 * Copyright (c) 2016 Kerem Güneş
 *     <k-gun@mail.com>
 *
 * GNU General Public License v3.0
 *     <http://www.gnu.org/licenses/gpl-3.0.txt>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
declare(strict_types=1);

namespace Froq\Collection;

use Froq\Util\Interfaces\Arrayable;
use Froq\Util\Arrays;

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
        $data && $this->setData($data);
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any        $value
     * @return void
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
    public function __isset($key): bool
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
     * Set data.
     * @param  array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
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
        if ($key === null) {
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
    public function unset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Offset set.
     * @param  int|string $key
     * @param  any        $value
     * @return void
     */
    final public function offsetSet($key, $value)
    {
        return $this->set($key, $value);
    }

    /**
     * Offset get.
     * @param  int|string $key
     * @return any
     */
    final public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Offset unset.
     * @param  int|string $key
     * @return void
     */
    final public function offsetUnset($key)
    {
        $this->unset($key);
    }

    /**
     * Offset exists.
     * @param  int|string $key
     * @return bool
     */
    final public function offsetExists($key): bool
    {
        return $this->isset($key);
    }

    /**
     * Count.
     * @return int
     */
    final public function count(): int
    {
        return count($this->data);
    }

    /**
     * Get iterator.
     * @return \ArrayIterator
     */
    final public function getIterator(): \ArrayIterator
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
     * @param  any        $value
     * @return any
     */
    final public function dig($key, $value = null)
    {
        return Arrays::dig($this->data, $key, $value);
    }

    /**
     * Empty.
     * @return void
     */
    final public function empty()
    {
        $this->data = [];
    }

    /**
     * Is empty.
     * @return bool
     */
    final public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Keys.
     * @return array
     */
    final public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Values.
     * @return array
     */
    final public function values(): array
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
     * Has keys.
     * @param  array $keys
     * @return bool
     */
    public function hasKeys(array $keys): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $this->data)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Has value.
     * @param  array $value
     * @param  bool  $strict
     * @return bool
     */
    public function hasValue($value, bool $strict = false): bool
    {
        return Arrays::index($this->data, $value, $strict) !== null;
    }

    /**
     * Has values.
     * @param  array $values
     * @param  bool  $strict
     * @return bool
     */
    public function hasValues(array $values, bool $strict = false): bool
    {
        foreach ($values as $value) {
            if (!$this->hasValue($value, $strict)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Prepend.
     * @param  any $value
     * @return self
     */
    public function prepend($value): self
    {
        array_unshift($this->data, $value);
        return $this;
    }

    /**
     * Append.
     * @param  any $value
     * @return self
     */
    public function append($value): self
    {
        array_push($this->data, $value);
        return $this;
    }

    /**
     * Put.
     * @param  int|string $key
     * @param  any        $value
     * @param  int|string $keySearch
     * @param  bool       $prev
     * @return self
     */
    public function put($key, $value, $keySearch = null, bool $prev = false): self
    {
        if ($keySearch !== null && $this->isset($keySearch)) {
            $i = Arrays::index(array_keys($this->data), $keySearch);
            if ($prev) {
                $i -= 1;
            }
            $this->data = array_merge(array_slice($this->data, 0, $i + 1),
                [$key => $value], array_slice($this->data, $i + 1));
        } elseif ($prev) {
            $this->data = array_merge([$key => $value], array_slice($this->data, 0));
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Put prev.
     * @param  int|string $key
     * @param  any        $value
     * @param  int|string $keySearch
     * @return self
     */
    public function putPrev($key, $value, $keySearch = null): self
    {
        return $this->put($key, $value, $keySearch, true);
    }

    /**
     * Put next.
     * @param  int|string $key
     * @param  any        $value
     * @param  int|string $keySearch
     * @return self
     */
    public function putNext($key, $value, $keySearch = null): self
    {
        return $this->put($key, $value, $keySearch, false);
    }

    /**
     * Put.
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
    public function remove($key)
    {
        $this->unset($key);
    }

    /**
     * Item.
     * @param  int|string $key
     * @return ?any
     */
    public function item($key)
    {
        return $this->get($key);
    }

    /**
     * Items.
     * @param  array $keys
     * @return array
     */
    public function items(array $keys): array
    {
        $return = [];
        foreach ($keys as $key) {
            $return[$key] = $this->get($key);
        }
        return $return;
    }

    /**
     * Item first.
     * @return ?any
     */
    public function itemFirst()
    {
        return Arrays::first($this->data);
    }

    /**
     * Item last.
     * @return ?any
     */
    public function itemLast()
    {
        return Arrays::last($this->data);
    }
}
