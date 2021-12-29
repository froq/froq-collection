<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AbstractCollection;
use froq\collection\trait\{AccessTrait, GetTrait, HasTrait};
use ArrayAccess;

/**
 * Array Object.
 *
 * Represents a simple but very extended array-object structure (not like `ArrayObject`) with
 * some utility methods.
 *
 * @package froq\collection
 * @object  froq\collection\ArrayObject
 * @author  Kerem Güneş
 * @since   5.14, 5.15 Refactored extending AbstractCollection.
 */
class ArrayObject extends AbstractCollection implements ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\GetTrait
     * @see froq\collection\trait\HasTrait
     */
    use AccessTrait, GetTrait, HasTrait;

    /**
     * Add an item.
     *
     * @param  mixed $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function add(mixed $value): self
    {
        $this->readOnlyCheck();

        $this->data[] = $value;

        return $this;
    }

    /**
     * Set an item.
     *
     * @param  int|string $key
     * @param  mixed      $value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function set(int|string $key, mixed $value): self
    {
        $this->readOnlyCheck();

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed|null
     */
    public function get(int|string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * Remove an item.
     *
     * @param  int|string  $key
     * @param  any|null   &$value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function remove(int|string $key, &$value = null): bool
    {
        $this->readOnlyCheck();

        if (array_key_exists($key, $this->data)) {
            $value = $this->data[$key];
            unset($this->data[$key]);
            return true;
        }
        return false;
    }

    /**
     * Replace an item with new one.
     *
     * @param  any              $oldValue
     * @param  any              $newValue
     * @param  int|string|null &$key
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    public function replace($oldValue, $newValue, int|string &$key = null): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldValue, $this->data, key: $key)) {
            $this->data[$key] = $newValue;
            return true;
        }
        return false;
    }
}
