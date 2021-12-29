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
     * @param bool     $pad
     */
    public static function split(string $string, string $pattern, int $limit = null, int $flags = null,
        bool $pad = true)
    {
        return new static(split($pattern, $string, $limit, $flags, $pad));
    }

    /**
     * Static initializer for string with RegExp split pattern.
     *
     * @param  string   $string
     * @param  string   $pattern
     * @param  int|null $limit
     * @param  int|null $flags
     * @param  bool     $blanks
     * @param  bool     $pad
     * @throws froq\collection\CollectionException
     */
    public static function splitRegExp(string $string, string $pattern, int $limit = null, int $flags = null,
        bool $pad = true, bool $blanks = false)
    {
        $limit ??= -1;
        $flags ??= 0;

        $data = preg_split($pattern, $string, $limit, $flags);
        if ($data === false) {
            throw new CollectionException(
                preg_error_message('preg_split') ?? 'Unknown error'
            );
        }

        // Drop empties if no-empty flag not given.
        if (!$blanks && !($flags & PREG_SPLIT_NO_EMPTY)) {
            $data = array_slice($data, 1, -1);
        }

        // Pad up to given limit.
        if ($pad && $limit && $limit != count($data)) {
            $data = array_pad($data, $limit, null);
        }

        return new static($data);
    }
}
