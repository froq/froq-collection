<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `keys()` and `values()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\KeysValuesTrait
 * @author  Kerem Güneş
 * @since   7.2
 */
trait KeysValuesTrait
{
    /**
     * Get keys.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Get values.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->data);
    }
}
