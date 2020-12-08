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
 * ItemCollection.
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
     * Access & Access Magic Trait.
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /**
     * Constructor.
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
     * @param  array $data
     * @param  bool  $override
     * @return self (static)
     * @throws froq\collection\CollectionException
     * @override
     */
    public final function setData(array $data, bool $override = true): self
    {
        foreach (array_keys($data) as $key) {
            if ($key === '') {
                throw new CollectionException("Only int keys are accepted for '%s' object, "
                    . "empty string (probably null key) given", [static::class]);
            }
            if (!is_int($key)) {
                throw new CollectionException("Only int keys are accepted for '%s' object, "
                    . "'%s' given", [static::class, gettype($key)]);
            }
        }

        return parent::setData($data, $override);
    }

    /**
     * Item.
     * @param  int $index
     * @return any|null
     */
    public final function item(int $index)
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Items.
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
     * Has.
     * @param  int $index
     * @return bool
     */
    public final function has(int $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * Has index.
     * @param  int $index
     * @return bool
     */
    public final function hasIndex(int $index): bool
    {
        return array_key_exists($index, $this->data);
    }

    /**
     * Has value.
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return in_array($value, $this->data, $strict);
    }

    /**
     * Add.
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
     * Set.
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
     * Get.
     * @param  int      $index
     * @param  any|null $itemDefault
     * @return any|null
     */
    public final function get(int $index, $itemDefault = null)
    {
        return $this->data[$index] ?? $itemDefault;
    }

    /**
     * Remove.
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
     * Replace.
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
