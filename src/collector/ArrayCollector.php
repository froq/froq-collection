<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\collector;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};

/**
 * A collector class designed to provide key-type check and read-only state, an array-like
 * structure with some utility methods.
 *
 * @package froq\collection\collector
 * @class   froq\collection\collector\ArrayCollector
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.17, 6.0
 */
class ArrayCollector extends AbstractCollector implements \ArrayAccess
{
    use AccessTrait, AccessMagicTrait, GetTrait;

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function add(mixed $value): self
    {
        return $this->_add($value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function set(int|string $key, mixed $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function &get(int|string $key, mixed $default = null): mixed
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function remove(int|string $key): bool
    {
        return $this->_remove($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function removeValue(mixed $value): bool
    {
        return $this->_removeValue($value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function replace(int|string $key, mixed $value): bool
    {
        return $this->_replace($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function replaceValue(mixed $oldValue, mixed $newValue): bool
    {
        return $this->_replaceValue($oldValue, $newValue);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function has(int|string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasKey(int|string $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasValue(mixed $value, int|string &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
