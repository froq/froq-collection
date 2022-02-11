<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\common\trait\ReadOnlyCallTrait;
use froq\common\exception\{InvalidArgumentException, RuntimeException};
use froq\util\Arrays;

/**
 * Apply Trait.
 *
 * Represents a trait entity that provides `apply()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ApplyTrait
 * @author  Kerem Güneş
 * @since   5.10
 */
trait ApplyTrait
{
    /** @see froq\common\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply a given action on data array.
     *
     * @param  callable $func
     * @param  bool     $swap
     * @param  bool     $recursive
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function apply(callable $func, bool $swap = false, bool $recursive = false): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::apply($this->data, $func, $swap, $recursive);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange(__function__);
        }

        return $this;
    }
}
