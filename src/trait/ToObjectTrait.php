<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * A trait, provides `toObject()` and `object()` methods.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ToObjectTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait ToObjectTrait
{
    /**
     * Get data array as object (stdClass).
     *
     * @return object
     */
    public function toObject(): object
    {
        return (object) $this->data;
    }

    /**
     * @alias toObject()
     */
    public function object()
    {
        return $this->toObject();
    }
}
