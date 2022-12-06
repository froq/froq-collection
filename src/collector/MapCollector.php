<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\collector;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};
use Map;

/**
 * A collector class designed to provide key-type check and read-only state, a map-like
 * structure with some utility methods.
 *
 * @package froq\collection\collector
 * @class   froq\collection\collector\MapCollector
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.16, 6.0
 */
class MapCollector extends AbstractCollector implements \ArrayAccess
{
    use AccessTrait, AccessMagicTrait, GetTrait;

    /**
     * @override
     */
    public function __construct(iterable|Map $data = [], bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function set(string $key, mixed $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function &get(string $key, mixed $default = null): mixed
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function remove(string $key): bool
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
    public function replace(string $key, mixed $value): bool
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
    public function has(string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasKey(string $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * @inheritDoc froq\collection\collector\AbstractCollector
     */
    public function hasValue(mixed $value, string &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
