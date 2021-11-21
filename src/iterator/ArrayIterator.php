<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\iterator\Iterator;

/**
 * Array Iterator.
 *
 * Represents an array iterator class that contains some utility methods (via its parent).
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\ArrayIterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class ArrayIterator extends Iterator
{
    /**
     * Constructor.
     *
     * @param array $data
     * @param bool  $readOnly
     */
    public function __construct(array $data, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }
}
