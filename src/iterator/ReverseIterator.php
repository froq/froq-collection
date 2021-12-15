<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\iterator\Iterator;

/**
 * Reverse Iterator.
 *
 * Represents a reverse iterator class that contains some utility methods (via its parent).
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\ReverseIterator
 * @author  Kerem Güneş
 * @since   5.16
 */
class ReverseIterator extends Iterator
{
    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     * @param bool      $keepKeys
     */
    public function __construct(iterable $data, bool $readOnly = null, bool $keepKeys = false)
    {
        parent::__construct($data, $readOnly);

        $this->data = array_reverse($this->data, $keepKeys);
    }
}
