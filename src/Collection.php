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
use Froq\Util\Collection as CollectionUtil;

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
     * @param array $data;
     */
    public function __construct(array $data = null)
    {
        $data && $this->setData($data);
    }

    /**
     * Set.
     * @param  int|string $key
     * @param  any $value
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
        return array_key_exists($key, $this->data);
    }

    /**
     * Unset.
     * @param  int|string $key
     * @return void
     */
    public function __unset($key)
    {
        unset($this->data[$key]);
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
     * @param  any $value
     * @return void
     */
    public function set($key, $value)
    {
        if ($key === null) {
            $this->data[] = $value;
        } else {
            $this->data[$key] = $value;
        }
    }

    /**
     * Get.
     * @param  int|string $key
     * @param  any $valueDefault
     * @return any
     */
    public function get($key, $valueDefault = null)
    {
        return $this->dig($key, $valueDefault);
    }

    /**
     * Isset.
     * @param  int|string $key
     * @return bool
     */
    public function isset($key): bool
    {
        return $this->__isset($key);
    }

    /**
     * Unset.
     * @param  int|string $key
     * @return void
     */
    public function unset($key)
    {
        $this->__unset($key);
    }

    /**
     * Offset set.
     * @param  int|string $key
     * @param  any $value
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
        $this->__unset($key);
    }

    /**
     * Offset exists.
     * @param  int|string $key
     * @return bool
     */
    final public function offsetExists($key): bool
    {
        return $this->__isset($key);
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
     * Generate iterator (from \IteratorAggregate).
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
     * Dig (getter with dot notation support for sub-array paths).
     * @param  int|string $key (aka path)
     * @param  any $valueDefault
     * @return any
     */
    final public function dig($key, $valueDefault = null)
    {
        return CollectionUtil::dig($this->data, $key, $valueDefault);
    }

    /**
     * Empty.
     * @return bool
     */
    final public function empty(): bool
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
        return $this->__isset($key);
    }

    /**
     * Remove.
     * @param  int|string $key
     * @return void
     */
    public function remove($key)
    {
        $this->__unset($key);
    }
}
