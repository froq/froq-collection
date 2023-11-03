<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides `toJson()` and `json()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\ToJsonTrait
 * @author  Kerem Güneş
 * @since   5.7, 6.0
 */
trait ToJsonTrait
{
    /**
     * Get data array as JSON string.
     *
     * @param  int $flags
     * @return string
     */
    public function toJson(int $flags = 0): string
    {
        return (string) json_encode($this->data, $flags);
    }

    /**
     * @alias toJson()
     */
    public function json(...$args)
    {
        return $this->toJson(...$args);
    }
}
