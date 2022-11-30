<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `toList()` and `list()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ToListTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait ToListTrait
{
    /**
     * Get data array as list.
     *
     * @return array
     */
    public function toList(): array
    {
        return array_values($this->data);
    }

    /**
     * @alias toList()
     */
    public function list()
    {
        return $this->toList();
    }
}
