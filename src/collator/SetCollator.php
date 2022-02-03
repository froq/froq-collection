<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\collator\{AbstractCollator, CollatorInterface, CollatorTrait};

/**
 * Set Collator.
 *
 * Represents a class entity designed to check unique values and provide read-only state
 * and set-like structure with some utility methods.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\SetCollator
 * @author  Kerem Güneş
 * @since   4.0, 5.4, 5.16
 */
class SetCollator extends AbstractCollator implements CollatorInterface
{
    /** @see froq\collection\collator\CollatorTrait */
    use CollatorTrait;

    /**
     * Constructor.
     *
     * @param array<int, any>|null $data
     * @param bool|null            $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Set data.
     *
     * @param  array<int, any> $data
     * @param  bool            $reset
     * @return self
     * @override
     */
    public final function setData(array $data, bool $reset = true): self
    {
        // Deduplicate repeating values.
        $data = array_dedupe($data);

        return parent::setData($data, $reset);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function add($value): self
    {
        if (!$this->_hasValue($value)) {
            $this->_add($value);
        }

        return $this;
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function set(int $key, $value): self
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

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function get(int $key, $default = null)
    {
        return $this->_get($key, $default);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function remove(int $key, &$value = null): bool
    {
        return $this->_remove($key, $value, true);
    }

    /** @inheritDoc froq\collection\collator\CollatorTrait */
    public final function removeValue($value, int &$key = null): bool
    {
        return $this->_removeValue($value, $key, true);
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
