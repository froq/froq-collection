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
 * Collator.
 *
 * Represents a class entity designed to check key types and provide read-only state & some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\Collator
 * @author  Kerem Güneş
 * @since   4.0, 5.4
 */
class Collator extends AbstractCollection implements CollatorInterface, ArrayAccess
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
     * @param array<int|string, any>|null $data
     * @param bool|null                   $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
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
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function add($value): self
    {
        return $this->_add($value);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function set(int|string $key, $value): self
    {
        return $this->_set($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function get(int|string $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function remove(int|string $key, &$value = null): bool
    {
        return $this->_remove($key, $value);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function removeValue($value, int|string &$key = null): bool
    {
        return $this->_removeValue($value, $key);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function has(int|string $key): bool
    {
        return $this->_has($key);
    }

    /**
     * @inheritDoc froq\collection\collator\CollatorTrait
     */
    public final function hasKey(int|string $key): bool
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
