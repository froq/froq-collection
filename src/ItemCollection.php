<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\trait\{AccessTrait, GetTrait};

/**
 * Item Collection.
 *
 * A simple array class, accepts int keys only.
 *
 * @package froq\collection
 * @object  froq\collection\ItemCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class ItemCollection extends AbstractCollection implements \ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\GetTrait
     */
    use AccessTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array<int, any>|null $data
     * @param bool|null            $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Get an item by given index.
     *
     * @param  int $index
     * @return any|null
     */
    public final function item(int $index)
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Get all items.
     *
     * @param  array<int>|null $indexes
     * @return array<int, any>
     */
    public final function items(array $indexes = null): array
    {
        if (!func_num_args()) {
            return $this->data;
        }

        $items = [];
        foreach ($indexes as $index) {
            $items[$index] = $this->item($index);
        }
        return $items;
    }

    /**
     * Check whether given index set in data array.
     *
     * @param  int $index
     * @return bool
     */
    public final function has(int $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * Check whether given index exists in data array.
     *
     * @param  int $index
     * @return bool
     */
    public final function hasIndex(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * Check whether given item exists in data array (with/without strict mode).
     *
     * @param  any  $item
     * @param  bool $strict
     * @return bool
     */
    public final function hasItem($item, bool $strict = true): bool
    {
        return array_value_exists($item, $this->data, $strict);
    }

    /**
     * Add (append) an item to data array.
     *
     * @param  any $item
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function add($item): self
    {
        $this->readOnlyCheck();

        $this->data[] = $item;

        return $this;
    }

    /**
     * Put an item by given index to data array.
     *
     * @param  int $index
     * @param  any $item
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidIndexException
     */
    public final function set(int $index, $item): self
    {
        $this->readOnlyCheck();
        $this->keyCheck($index);

        $this->data[$index] = $item;

        return $this;
    }

    /**
     * Get an item by given index from data array.
     *
     * @param  int      $index
     * @param  any|null $default
     * @return any|null
     * @causes froq\common\exception\InvalidIndexException
     */
    public final function get(int $index, $default = null)
    {
        $this->keyCheck($index);

        return $this->data[$index] ?? $default;
    }

    /**
     * Remove an item by given index from data array by given index.
     *
     * @param  int       $index
     * @param  any|null &$item
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidIndexException
     */
    public final function remove(int $index, &$item = null): bool
    {
        $this->readOnlyCheck();
        $this->keyCheck($index);

        if (array_key_exists($index, $this->data)) {
            $item = $this->data[$index];
            unset($this->data[$index]);

            return true;
        }

        return false;
    }

    /**
     * Replace an item with new one.
     *
     * @param  any $oldItem
     * @param  any $newItem
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function replace($oldItem, $newItem): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldItem, $this->data, key: $index)) {
            $this->data[$index] = $newItem;

            return true;
        }

        return false;
    }
}
