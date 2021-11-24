<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\Collection;

/**
 * Split Collection.
 *
 * Represents a collection structure that utilies string splitting stuff.
 *
 * @package froq\collection
 * @object  froq\collection\SplitCollection
 * @author  Kerem Güneş
 * @since   5.9
 */
class SplitCollection extends Collection
{
    /**
     * Constructor.
     *
     * @param string   $string
     * @param string   $pattern
     * @param int|null $limit
     */
    public function __construct(string $pattern, string $string = null, int|null $limit = null)
    {
        parent::__construct(split($pattern, $string, limit: $limit));
    }
}
