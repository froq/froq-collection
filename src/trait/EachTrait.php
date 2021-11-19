<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\collection\trait\ReadOnlyCallTrait;
use froq\util\Arrays;

/**
 * Each Trait.
 *
 * Represents a trait entity that provides `each()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\EachTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait EachTrait
{
    /** @see froq\collection\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply given action on each item of data array.
     *
     * @param  callable $func
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function each(callable $func): self
    {
        $this->readOnlyCall();

        foreach ($this->data as $key => &$value) {
            $func($value, $key);
        }

        unset($value); // Drop last ref.

        return $this;
    }
}
