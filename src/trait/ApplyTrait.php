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
 * Apply Trait.
 *
 * A trait, provides `apply()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ApplyTrait
 * @author  Kerem Güneş
 * @since   5.10
 */
trait ApplyTrait
{
    use CallTrait;

    /**
     * Apply given action on data array.
     *
     * @param  callable $func
     * @param  bool     $recursive
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function apply(callable $func, bool $recursive = false): self
    {
        // For read-only check.
        $this->call('readOnlyCheck');

        $this->data = Arrays::apply($this->data, $func, $recursive);

        // For some internal data changes.
        $this->call('onDataChange', __function__);

        return $this;
    }
}
