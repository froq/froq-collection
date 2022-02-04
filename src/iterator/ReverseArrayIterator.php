<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

/**
 * Reverse Array Iterator.
 *
 * A reverse-array iterator class that contains some utility methods (by its parent).
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
     * @param array     $data
     * @param bool|null $readOnly
     * @param bool      $keepKeys
     */
    public function __construct(array $data, bool $readOnly = null, bool $keepKeys = false)
    {
        parent::__construct(array_reverse($data, $keepKeys), $readOnly);
    }
}
