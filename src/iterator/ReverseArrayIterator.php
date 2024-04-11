<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\iterator;

/**
 * An extended reverse `ArrayIterator` class.
 *
 * @package froq\collection\iterator
 * @class   froq\collection\iterator\ReverseArrayIterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class ReverseArrayIterator extends ArrayIterator
{
    /**
     * @override
     */
    public function __construct(iterable $data = [], bool $keepKeys = false)
    {
        $items = [];
        foreach ($data as $key => $value) {
            $items[$key] = $value;
        }

        parent::__construct(array_reverse($items, $keepKeys));
    }
}
