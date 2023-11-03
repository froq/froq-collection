<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `count()` method.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\CountTrait
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
