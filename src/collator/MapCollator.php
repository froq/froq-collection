<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};
use Map;

/**
 * Map Collator.
 *
 * A collator class designed to check key types and provide read-only state, map-like
 * structure with some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\MapCollator
 * @author  Kerem Güneş
 * @since   4.0, 5.4
 */
class MapCollator extends AbstractCollator implements \ArrayAccess
{
    /** @see froq\collection\trait\*Trait */
    use AccessTrait, AccessMagicTrait, GetTrait;

    /**
     * Constructor.
     *
     * @param array|Map|null $data
     * @param bool|null      $readOnly
     */
    public function __construct(array|Map $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function set(string $key, mixed $value): self
    {
        return $this->_set($key, $value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function get(string $key, mixed $default = null): mixed
    {
        return $this->_get($key, $default);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function remove(string $key, mixed &$value = null): bool
    {
        return $this->_remove($key, $value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function removeValue(mixed $value, string &$key = null): bool
    {
        return $this->_removeValue($value, $key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function replace(string $key, mixed $value): bool
    {
        return $this->_replace($key, $value);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function replaceValue(mixed $oldValue, mixed $newValue, string &$key = null): bool
    {
        return $this->_replaceValue($oldValue, $newValue, $key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function has(string $key): bool
    {
        return $this->_has($key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function hasKey(string $key): bool
    {
        return $this->_hasKey($key);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function hasValue(mixed $value, string &$key = null): bool
    {
        return $this->_hasValue($value, $key);
    }
}
