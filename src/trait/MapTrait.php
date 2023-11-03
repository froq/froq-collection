<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\common\trait\CallTrait;
use froq\util\Arrays;

/**
 * A trait, provides `map()` and `mapKeys()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\MapTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait MapTrait
{
    use CallTrait;

    /**
     * Apply a map action on data array.
     *
     * @param  callable|string|array $func
     * @param  bool                  $recursive
     * @param  bool                  $keepKeys
     * @return self
     */
    public function map(callable|string|array $func, bool $recursive = false, bool $useKeys = false, bool $keepKeys = true): self
    {
        $this->data = Arrays::map($this->data, $func, $recursive, $useKeys, $keepKeys);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }

    /**
     * Apply a map action on data array keys.
     *
     * @param  callable|string|array $func
     * @param  bool                  $recursive
     * @return self
     */
    public function mapKeys(callable|string|array $func, bool $recursive = false): self
    {
        $this->data = Arrays::mapKeys($this->data, $func, $recursive);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }
}
