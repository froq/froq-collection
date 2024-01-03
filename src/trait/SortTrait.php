<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\common\trait\CallTrait;
use froq\util\Arrays;

/**
 * A trait, provides `sort()`, `sortKey()`, `sortLocale()` and `sortNatural()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\SortTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait SortTrait
{
    use CallTrait;

    /**
     * Apply a sort on data array.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @param  bool|null         $assoc
     * @return self
     */
    public function sort(callable|int $func = null, int $flags = 0, bool $assoc = null): self
    {
        $this->data = Arrays::sort($this->data, $func, $flags, $assoc);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }

    /**
     * Apply a key sort on data array.
     *
     * @param  callable|int|null $func
     * @param  int               $flags
     * @return self
     */
    public function sortKey(callable|int $func = null, int $flags = 0): self
    {
        $this->data = Arrays::sortKey($this->data, $func, $flags);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }

    /**
     * Apply a locale sort on data array.
     *
     * @param  string|null $locale
     * @param  bool|null   $assoc
     * @return self
     */
    public function sortLocale(string $locale = null, bool $assoc = null): self
    {
        $this->data = Arrays::sortLocale($this->data, $locale, $assoc);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }

    /**
     * Apply a natural sort on data array.
     *
     * @param  bool $icase
     * @return self
     */
    public function sortNatural(bool $icase = false): self
    {
        $this->data = Arrays::sortNatural($this->data, $icase);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }
}
