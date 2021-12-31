<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\object;

use froq\collection\AbstractCollection;
use froq\collection\trait\{AccessTrait, GetTrait, HasTrait};
use froq\common\exception\InvalidIndexException;
use ArrayAccess;

/**
 * List Object.
 *
 * Represents a simple but very extended list-object structure with
 * some utility methods.
 *
 * @package froq\collection\object
 * @object  froq\collection\object\ListObject
 * @author  Kerem Güneş
 * @since   5.27
 */
class ListObject extends AbstractCollection implements ArrayAccess
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
     * @param  int   $index
     * @param  mixed $value
     * @return self
     * @causes froq\common\exception\InvalidIndexException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function set(int $index, mixed $value): self
    {
        $this->indexCheck($index);
        $this->readOnlyCheck();

        // Maintain next index.
        if ($index > $nextIndex = $this->count()) {
            $index = $nextIndex;
        }

        $this->data[$index] = $value;

        return $this;
    }

    /**
     * Get an item.
     *
     * @param  int        $index
     * @param  mixed|null $default
     * @return mixed|null
     * @causes froq\common\exception\InvalidIndexException
     */
    public function get(int $index, mixed $default = null): mixed
    {
        $this->indexCheck($index);

        return $this->data[$index] ?? $default;
    }

    /**
     * Remove an item.
     *
     * @param  int         $index
     * @param  any|null   &$value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function remove(int $index, &$value = null): bool
    {
        $this->indexCheck($index);
        $this->readOnlyCheck();

        if (array_key_exists($index, $this->data)) {
            $value = $this->data[$index];
            unset($this->data[$index]);

            // Re-index.
            $this->data = array_values($this->data);

            return true;
        }

        return false;
    }

    /**
     * Replace an item with new one.
     *
     * @param  any              $oldValue
     * @param  any              $newValue
     * @param  int|null        &$index
     * @return bool
     * @causes froq\common\exception\InvalidIndexException
     * @causes froq\common\exception\ReadOnlyException
     */
    public function replace($oldValue, $newValue, int &$index = null): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldValue, $this->data, key: $index)) {
            $this->data[$index] = $newValue;

            return true;
        }

        return false;
    }

    /**
     * Check index validity.
     *
     * @param  int|null $index
     * @return void
     * @throws froq\collection\InvalidIndexException
     */
    private function indexCheck(int|null $index): void
    {
        if ($index && !is_int($index)) throw new InvalidIndexException(
            'Invalid index type, index type must be int'
        );

        // Note: evaluates "'' < 0" true.
        if ($index < 0) throw new InvalidIndexException(
            'Invalid index, index must be greater than or equal to 0'
        );
    }
}
