<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{AbstractCollection, CollectionException, AccessTrait, AccessMagicTrait};
use ArrayAccess;

/**
 * Item Collection.
 *
 * Represents a simple array structure that accepts int keys only, and also prevents modifications
 * in read-only mode. Inspired by JavaScript's DOMTokenList.
 *
 * @package froq\collection
 * @object  froq\collection\ItemCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class ItemCollection extends AbstractCollection implements ArrayAccess
{
    /**
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /**
     * Constructor.
     *
     * @param array<int, any>|null $data
     * @param bool|null            $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data);

        $this->readOnly($readOnly);
    }

    /**
     * Set data.
     *
     * @param  array<int, any> $data
     * @param  bool            $reset
     * @return self
     * @override
     */
    public final function setData(array $data, bool $reset = true): self
    {
        return parent::setData($data, $reset);
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
        if ($indexes == null) {
            return $this->data;
        }

        $items = [];
        foreach ($indexes as $index) {
            $items[$index] = $this->item($index);
        }
        return $items;
    }

    /**
     * Check whether an indexed item exists in data stack.
     *
     * @param  int $index
     * @return bool
     */
    public final function has(int $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * Check whether an index exists in data stack.
     *
     * @param  int $index
     * @return bool
     */
    public final function hasIndex(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * Check with/without strict mode whether data stack has given value.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
    }

    /**
     * Add (append) an item to data stack.
     *
     * @param  any $item
     * @return self
     */
    public final function add($item): self
    {
        $this->readOnlyCheck();

        $this->data[] = $item;

        return $this;
    }

    /**
     * Put an item by given index to data stack.
     *
     * @param  int $index
     * @param  any $item
     * @return self
     */
    public final function set(int $index, $item): self
    {
        $this->readOnlyCheck();

        $this->data[$index] = $item;

        return $this;
    }

    /**
     * Get an item by given index from data stack.
     *
     * @param  int      $index
     * @param  any|null $default
     * @return any|null
     */
    public final function get(int $index, $default = null)
    {
        return $this->data[$index] ?? $default;
    }

    /**
     * Remove an item by given index from data stack by given index.
     *
     * @param  int $index
     * @return bool
     */
    public final function remove(int $index): bool
    {
        $this->readOnlyCheck();

        if (isset($this->data[$index])) {
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
     */
    public final function replace($oldItem, $newItem): bool
    {
        $this->readOnlyCheck();

        foreach ($this->data as $index => $item) {
            if ($item === $oldItem) {
                $this->data[$index] = $newItem;
                return true;
            }
        }
        return false;
    }
}
