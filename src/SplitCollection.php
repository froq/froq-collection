<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\{Collection, CollectionException};

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
     * Static initializer for string with regular split pattern.
     *
     * @param string   $string
     * @param string   $pattern
     * @param int|null $limit
     * @param int|null $flags
     */
    public static final function split(string $string, string $pattern, int $limit = null, int $flags = null)
    {
        return new static(split($pattern, $string, $limit, $flags));
    }

    /**
     * Static initializer for string with RegExp split pattern.
     *
     * @param  string   $string
     * @param  string   $pattern
     * @param  int|null $limit
     * @param  int|null $flags
     * @throws froq\collection\CollectionException
     */
    public static final function splitRegExp(string $string, string $pattern, int $limit = null, int $flags = null)
    {
        try {
            $regx = \RegExp::fromPattern($pattern, throw: true);
            return new static($regx->split($string, $limit ?? -1, $flags ?? 0));
        } catch (\RegExpError $e) {
            throw new CollectionException($e->getMessage(), code: $e->getCode(), cause: $e);
        }
    }
}
