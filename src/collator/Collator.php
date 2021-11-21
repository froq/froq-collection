<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\collator\{CollatorException, CollatorTrait};
use froq\collection\AbstractCollection;
use ArrayAccess;

/**
 * Collator.
 *
 * Represents a class entity designed to check key types and provide read-only state & some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\Collator
 * @author  Kerem Güneş
 * @since   4.0, 5.4 Moved as stack => collator.
 */
class Collator extends AbstractCollection implements ArrayAccess
{
    /** @see froq\collection\collator\CollatorTrait */
    use CollatorTrait;

    /**
     * Constructor.
     *
     * @param array<int|string, any>|null $data
     * @param bool|null                   $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data);

        $this->readOnly($readOnly);
    }

    /**
     * Set data.
     *
     * @param  array<int|string, any> $data
     * @param  bool                   $reset
     * @return self
     * @override
     */
    public final function setData(array $data, bool $reset = true): self
    {
        return parent::setData($data, $reset);
    }

    /**
     * Add (append) an item to data array with given key.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function add(int|string $key, $value): self
    {
        return $this->_add($key, $value);
    }

    /**
     * Put an item to data array with given key.
     *
     * @param  int|string $key
     * @param  any        $value
     * @return self
     */
    public final function set(int|string $key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * Get an item from data array by given key.
     *
     * @param  int|string $key
     * @param  any|null   $default
     * @return any|null
     */
    public final function get(int|string $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /**
     * Remove an item from data array by given key.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function remove(int|string $key): bool
    {
        return $this->_remove($key);
    }

    /**
     * Check whether an item was set in data array with given key.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function has(int|string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * Check whether given key exists in data array.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function hasKey(int|string $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     *  Check with/without strict mode whether data array has given value.
     *
     * @param  any  $value
     * @param  bool $strict
     * @return bool
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return $this->_hasValue($value, $strict);
    }
}
