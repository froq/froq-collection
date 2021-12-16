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
 * Filter Trait.
 *
 * Represents a trait entity that provides `filter()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\FilterTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait FilterTrait
{
    /** @see froq\common\trait\ReadOnlyCallTrait */
    use ReadOnlyCallTrait;

    /**
     * Apply a filter action on data array.
     *
     * @param  callable|null $func
     * @param  bool          $keepKeys
     * @return self
     * @causes froq\common\exception\ReadOnlyException
     */
    public function filter(callable $func = null, bool $keepKeys = true): self
    {
        $this->readOnlyCall();

        $this->data = Arrays::filter($this->data, $func, $keepKeys);

        // For some internal data changes.
        if (method_exists($this, 'onDataChange')) {
            $this->onDataChange('filter');
        }

        return $this;
    }
}
