<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\iterator\ArrayIterator;

/**
 * Reverse Array Iterator.
 *
 * Represents a reverse-array iterator class entity that contains some utility methods (via its parent).
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\ReverseArrayIterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class ReverseArrayIterator extends ArrayIterator
{
    /**
     * Constructor.
     *
     * @param array $data
     * @param bool  $preserveKeys
     */
    public function __construct(array $data, bool $preserveKeys = true)
    {
        parent::__construct(array_reverse($data, $preserveKeys));
    }
}
