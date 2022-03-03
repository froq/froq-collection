<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\common\trait\CallTrait;
use froq\util\Arrays;

/**
 * Sort Trait.
 *
 * A trait, provides `sort()`, `sortKey()`, `sortLocale()` and `sortNatural()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\SortTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait SortTrait
{
    /** @see froq\common\trait\CallTrait */
    use CallTrait;

    /**
     * Apply a sort on data array.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @param  bool|null         $assoc
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sort(callable|int $func = null, $flags = 0, bool $assoc = null): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::sort($this->data, $func, $flags, $assoc);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }

    /**
     * Apply a key sort on data array.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortKey(callable|int $func = null, int $flags = 0): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::sortKey($this->data, $func, $flags);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }

    /**
     * Apply a locale sort on data array.
     *
     * @param  string|null $locale
     * @param  bool|null   $assoc
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function sortLocale(string $locale = null, bool $assoc = null): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::sortLocale($this->data, $locale, $assoc);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

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
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::sortNatural($this->data, $icase);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }
}
