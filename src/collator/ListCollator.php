<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\trait\{AccessTrait, GetTrait};

/**
 * List Collator.
 *
 * A collator class designed to check key types and provide read-only state, list-like
 * structure with some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\ListCollator
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.16
 */
class ListCollator extends AbstractCollator implements \ArrayAccess
{
    /** @see froq\collection\collator\CollatorTrait */
    use CollatorTrait;

    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\GetTrait
     */
    use AccessTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array<int, any>|null $data
     * @param bool|null            $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        // Values as list.
        if ($data) {
            $data = array_values($data);
        }

        parent::__construct($data, $readOnly);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function add($value): self
    {
        return $this->_add($value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function set(int $key, $value): self
    {
        // Maintain next key.
        if ($key > $nextKey = $this->count()) {
            $key = $nextKey;
        }

        return $this->_set($key, $value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function get(int $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function remove(int $key, &$value = null, bool $reset = true): bool
    {
        return $this->_remove($key, $value, $reset);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function removeValue($value, int &$key = null, bool $reset = true): bool
    {
        return $this->_removeValue($value, $key, $reset);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function replace(int $key, $value): bool
    {
        return $this->_replace($key, $value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function replaceValue($oldValue, $newValue, int &$key = null): bool
    {
        return $this->_replaceValue($oldValue, $newValue, $key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function has(int $key): bool
    {
        return $this->_has($key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function hasKey(int $key): bool
    {
        return $this->_hasKey($key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function hasValue($value, int &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
