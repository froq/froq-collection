<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection\stack;

use froq\collection\{AbstractCollection, AccessTrait, AccessMagicTrait};
use froq\collection\stack\{StackException, StackTrait};
use ArrayAccess;

/**
 * Map Stack.
 *
 * This is not an implementation of Stack (https://en.wikipedia.org/wiki/Stack_(abstract_data_type))
 * but simply designed to be able for checking key types here or in extender objects, and also to
 * prevent the modifications in read-only mode.
 *
 * @package froq\collection\stack
 * @object  froq\collection\stack\MapStack
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class MapStack extends AbstractCollection implements ArrayAccess
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
     * @param  array<string, any>|null $data
     * @param  bool|null               $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data);

        $this->readOnly($readOnly);
    }

    /**
     * Set data.
     *
     * @param  array<string, any> $data
     * @param  bool               $reset
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
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function add(string $key, $value): self
    {
        return $this->_add($key, $value);
    }

    /**
     * Put an item to data stack with given key.
     *
     * @param  string $key
     * @param  any    $value
     * @return self
     */
    public final function set(string $key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * Get an item from data stack by given key.
     *
     * @param  string   $key
     * @param  any|null $default
     * @return any|null
     */
    public final function get(string $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /**
     * Remove an item from data stack by given key.
     *
     * @param  string $key
     * @return bool
     */
    public final function remove(string $key): bool
    {
        return $this->_remove($key);
    }

    /**
     * Check whether an item was set in data stack with given key.
     *
     * @param  string $key
     * @return bool
     */
    public final function has(string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * Check whether given key exists in data stack.
     *
     * @param  string $key
     * @return bool
     */
    public final function hasKey(string $key): bool
    {
        return $this->_hasKey($key);
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
        return $this->_hasValue($value, $strict);
    }
}
