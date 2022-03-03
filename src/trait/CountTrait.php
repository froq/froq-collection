<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Count Trait.
 *
 * A trait, provides `count()` method.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\CountTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait CountTrait
{
    /**
     * Get count of data array.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->data);
    }
}
