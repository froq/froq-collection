<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\object;

use froq\collection\AbstractCollection;
use froq\collection\trait\{AccessTrait, GetTrait, HasTrait};

/**
 * A simple array-object structure (not like `ArrayObject`) with some utility methods.
 *
 * @package froq\collection\object
 * @object  froq\collection\object\ArrayObject
 * @author  Kerem Güneş
 * @since   5.14, 5.15
 */
class ArrayObject extends AbstractCollection implements \ArrayAccess
{
    use AccessTrait, GetTrait, HasTrait;

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
     * @causes froq\common\exception\InvalidKeyException
     */
    public function set(int|string $key, mixed $value): self
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Get an item.
     *
     * @param  int|string $key
     * @param  mixed|null $default
     * @return mixed|null
     * @causes froq\common\exception\InvalidKeyException
     */
    public function get(int|string $key, mixed $default = null): mixed
    {
        $this->keyCheck($key);

        return $this->data[$key] ?? $default;
    }

    /**
     * Remove an item.
     *
     * @param  int|string  $key
     * @param  mixed|null &$value
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     * @causes froq\common\exception\InvalidKeyException
     */
    public function remove(int|string $key, mixed &$value = null): bool
    {
        $this->readOnlyCheck();
        $this->keyCheck($key);

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
     * @param  mixed            $oldValue
     * @param  mixed            $newValue
     * @param  int|string|null &$key
     * @return bool
     * @causes froq\common\exception\ReadOnlyException
     */
    public function replace(mixed $oldValue, mixed $newValue, int|string &$key = null): bool
    {
        $this->readOnlyCheck();

        if (array_value_exists($oldValue, $this->data, key: $key)) {
            $this->data[$key] = $newValue;

            return true;
        }

        return false;
    }
}
