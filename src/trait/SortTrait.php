<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\common\trait\ReadOnlyCallTrait;
use froq\util\Arrays;

/**
 * Sort Trait.
 *
 * Represents a trait entity that provides some sorting methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\SortTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait SortTrait
{
    /** @see froq\common\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply a sort on data array.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @param  bool              $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sort(callable|int $func = null, $flags = 0, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::sort($this->data, $func, $flags, $keepKeys);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
        }

        return $this;
    }

    /**
     * Apply a key sort on data array.
     *
     * @param  callable|null $func
     * @param  int           $flags
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortKey(callable $func = null, int $flags = 0): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::sortKey($this->data, $func, $flags);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
        }

        return $this;
    }

    /**
     * Apply a locale sort on data array.
     *
     * @param  string|null $locale
     * @param  bool        $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortLocale(string $locale = null, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::sortLocale($this->data, $locale, $keepKeys);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
        }

        return $this;
    }

    /**
     * Apply a natural sort on data array.
     *
     * @param  bool $icase
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortNatural(bool $icase = false): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::sortNatural($this->data, $icase);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
        }

        return $this;
    }
}
