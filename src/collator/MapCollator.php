<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\collator\{CollatorException, CollatorInterface, CollatorTrait};
use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetAsTrait};
use froq\collection\AbstractCollection;
use ArrayAccess;

/**
 * Map Collator.
 *
 * Represents a class entity designed to check key types and provide read-only state & some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\MapCollator
 * @author  Kerem Güneş
 * @since   4.0, 5.4 Moved as stack => collator.
 */
class MapCollator extends AbstractCollection implements CollatorInterface, ArrayAccess
{
    /** @see froq\collection\collator\CollatorTrait */
    use CollatorTrait;

    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\AccessMagicTrait
     * @see froq\collection\trait\GetAsTrait
     * @since 4.0, 5.0
     */
    use AccessTrait, AccessMagicTrait, GetAsTrait;

    /**
     * Constructor.
     *
     * @param array<string, any>|null $data
     * @param bool|null               $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
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
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function add(string $key, $value, bool $flat = true): self
    {
        return $this->_add($key, $value, $flat);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function set(string $key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function get(string $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function remove(string $key, &$value = null): bool
    {
        return $this->_remove($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function has(string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function hasKey(string $key): bool
    {
        return $this->_hasKey($key);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function hasValue($value, bool $strict = true): bool
    {
        return $this->_hasValue($value, $strict);
    }
}
