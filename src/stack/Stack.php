<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\stack;

use froq\collection\{AbstractCollection, AccessTrait, AccessMagicTrait};
use froq\collection\stack\{StackException, StackTrait};
use ArrayAccess;

/**
 * Stack.
 *
 * This is not an implementation of Stack (https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
 * but simply designed to be able for checking key types here or in extender objects, and also to
 * prevent the modifications in read-only mode.
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\Stack
 * @author  Kerem Güneş
 * @since   4.0
 */
class Stack extends AbstractCollection implements ArrayAccess
{
    /** @see froq\collection\stack\StackTrait */
    use StackTrait;

    /**
     * @see froq\collection\AccessTrait
     * @see froq\collection\AccessMagicTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait;

    /**
     * Constructor.
     *
     * @param  array<int|string, any>|null $data
     * @param  bool|null                   $readOnly
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
     * Add (append) an item to data stack with given key.
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
     * Put an item to data stack with given key.
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
     * Get an item from data stack by given key.
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
     * Remove an item from data stack by given key.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function remove(int|string $key): bool
    {
        return $this->_remove($key);
    }

    /**
     * Check whether an item was set in data stack with given key.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function has(int|string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * Check whether given key exists in data stack.
     *
     * @param  int|string $key
     * @return bool
     */
    public final function hasKey(int|string $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     *  Check with/without strict mode whether data stack has given value.
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
