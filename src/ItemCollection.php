<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection;

use froq\collection\trait\{AccessTrait, GetTrait};

/**
 * A simple array class, accepts int keys only.
 *
 * @package froq\collection
 * @class   froq\collection\ItemCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class ItemCollection extends AbstractCollection implements \ArrayAccess
{
    use AccessTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array|null $data
     * @param bool|null  $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Get an item by given index.
     *
     * @param  int $index
     * @return mixed|null
     */
    public function item(int $index): mixed
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Get all items.
     *
     * @param  array<int>|null $indexes
     * @return array<int, mixed>
     */
    public function items(array $indexes = null): array
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
    public function has(int $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * Check whether given index exists in data array.
     *
     * @param  int $index
     * @return bool
     */
    public function hasIndex(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * Check whether given item exists in data array (with/without strict mode).
     *
     * @param  mixed $item
     * @param  bool  $strict
     * @return bool
     */
    public function hasItem(mixed $item, bool $strict = true): bool
    {
        return array_value_exists($item, $this->data, $strict);
    }

    /**
     * Add (append) an item to data array.
     *
     * @param  mixed $item
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function add(mixed $item): self
    {
        $this->readOnlyCheck();

        $this->data[] = $item;

        return $this;
    }

    /**
     * Put an item by given index to data array.
     *
     * @param  int   $index
     * @param  mixed $item
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidIndexException
     */
    public function set(int $index, mixed $item): self
    {
        $this->readOnlyCheck();
        $this->keyCheck($index);

        $this->data[$index] = $item;

        return $this;
    }

    /**
     * Get an item by given index from data array.
     *
     * @param  int        $index
     * @param  mixed|null $default
     * @return mixed|null
     * @causes froq\common\exception\InvalidIndexException
     */
    public function get(int $index, mixed $default = null): mixed
    {
        $this->keyCheck($index);

        return $this->data[$index] ?? $default;
    }

    /**
     * Remove an item by given index from data array by given index.
     *
     * @param  int         $index
     * @param  mixed|null &$item
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidIndexException
     */
    public function remove(int $index, mixed &$item = null): bool
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
     * @param  mixed $oldItem
     * @param  mixed $newItem
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    public function replace(mixed $oldItem, mixed $newItem): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldItem, $this->data, key: $index)) {
            $this->data[$index] = $newItem;

            return true;
        }

        return false;
    }
}
