<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

use froq\common\trait\CallTrait;
use froq\util\Arrays;

/**
 * A trait, provides `apply()` method.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ApplyTrait
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
     */
    public function apply(callable $func, bool $recursive = false): self
    {
        $this->data = Arrays::apply($this->data, $func, $recursive);

        // For some internal data changes.
        $this->call('onDataChange', __FUNCTION__);

        return $this;
    }
}
