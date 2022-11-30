<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collector;

use froq\collection\trait\{AccessTrait, GetTrait};
use Set;

/**
 * A collector class designed to provide key-type check and read-only state, a set-like
 * structure with some utility methods, ensures unique values.
 *
 * @package froq\collection\collector
 * @object  froq\collection\collector\SetCollector
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.16, 6.0
 */
class SetCollector extends AbstractCollector implements \ArrayAccess
{
    use AccessTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array|Set|null $data
     * @param bool|null      $readOnly
     */
    public function __construct(array|Set $data = null, bool $readOnly = null)
    {
        if ($data && is_array($data)) {
            $data = array_list($data);
            $data = array_dedupe($data);
        }

        parent::__construct($data, $readOnly);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function add(mixed $value): self
    {
        if (!$this->_hasValue($value)) {
            $this->_add($value);
        }

        return $this;
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function set(int $key, mixed $value): self
    {
        if (!$this->_hasValue($value)) {
            // Maintain next key.
            if ($key > $nextKey = $this->count()) {
                $key = $nextKey;
            }

            $this->_set($key, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function get(int $key, mixed $default = null): mixed
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function remove(int $key, mixed &$value = null): bool
    {
        return $this->_remove($key, $value, true);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function removeValue(mixed $value, int &$key = null): bool
    {
        return $this->_removeValue($value, $key, true);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function replace(int $key, mixed $value): bool
    {
        return $this->_replace($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function replaceValue(mixed $oldValue, mixed $newValue, int &$key = null): bool
    {
        return $this->_replaceValue($oldValue, $newValue, $key);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function has(int $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function hasKey(int $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * @inheritDoc froq\collection\collector\CollectorTrait
     */
    public function hasValue(mixed $value, int &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
