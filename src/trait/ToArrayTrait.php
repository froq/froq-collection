<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * To-Array Trait.
 *
 * A trait, provides `toArray()` and `array()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ToArrayTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait ToArrayTrait
{
    /**
     * Get data array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * @alias toArray()
     */
    public function array()
    {
        return $this->toArray();
    }
}