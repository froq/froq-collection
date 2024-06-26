<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `toObject()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ToObjectTrait
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
}
