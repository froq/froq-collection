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
 * Map Trait.
 *
 * A trait, provides `map()` and `mapKeys()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\MapTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait MapTrait
{
    /** @see froq\common\trait\CallTrait */
    use CallTrait;

    /**
     * Apply a map action on data array.
     *
     * @param  callable|string|array $func
     * @param  bool                  $recursive
     * @param  bool                  $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function map(callable|string|array $func, bool $recursive = false, bool $useKeys = false, bool $keepKeys = true): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::map($this->data, $func, $recursive, $useKeys, $keepKeys);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }

    /**
     * Apply a map action on data array keys.
     *
     * @param  callable $func
     * @param  bool     $recursive
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function mapKeys(callable $func, bool $recursive = false): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::mapKeys($this->data, $func, $recursive);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }
}
