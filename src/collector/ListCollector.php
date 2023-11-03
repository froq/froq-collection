<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\collector;

use froq\collection\trait\{AccessTrait, GetTrait};

/**
 * A collector class designed to provide key-type check and read-only state, a list-like
 * structure with some utility methods.
 *
 * @package froq\collection\collector
 * @class   froq\collection\collector\ListCollector
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.16, 6.0
 */
class ListCollector extends AbstractCollector implements \ArrayAccess
{
    use AccessTrait, GetTrait;

    /**
     * @override
     */
    public function __construct(iterable $data = [])
    {
        parent::__construct($data);

        // Make list.
        $data && $this->data = array_list($this->data);
    }

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
    public function set(int $key, mixed $value): self
    {
        // Maintain next key.
        if ($key > $nextKey = $this->count()) {
            $key = $nextKey;
        }

        return $this->_set($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function &get(int $key, mixed $default = null): mixed
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function remove(int $key, bool $reset = true): bool
    {
        return $this->_remove($key, $reset);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function removeValue(mixed $value, bool $reset = true): bool
    {
        return $this->_removeValue($value, $reset);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function replace(int $key, mixed $value): bool
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
    public function has(int $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasKey(int $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasValue(mixed $value, int &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
