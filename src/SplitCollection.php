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
 * A collection structure that utilies string splitting stuff.
 *
 * @package froq\collection
 * @object  froq\collection\SplitCollection
 * @author  Kerem Güneş
 * @since   5.9, 6.0
 */
class SplitCollection extends Collection
{
    /**
     * Constructor.
     *
     * @param string     $string
     * @param string     $pattern
     * @param int|null   $limit
     * @param int|null   $flags
     * @param bool|null  $readOnly
     * @param array|null $data @internal For static methods.
     */
    public function __construct(string $string, string $pattern, int $limit = null, int $flags = null,
        bool $readOnly = null, array $data = null)
    {
        // Internal call check.
        if (func_num_args() != 6) {
            $data = split($pattern, $string, $limit, $flags);
        }

        parent::__construct($data, $readOnly);
    }

    /**
     * Static initializer for string with regular split pattern.
     *
     * @param  string    $string
     * @param  string    $pattern
     * @param  int|null  $limit
     * @param  int|null  $flags
     * @param  bool|null $readOnly
     * @return static
     */
    public static final function split(string $string, string $pattern, int $limit = null, int $flags = null,
        bool $readOnly = null): static
    {
        $data = split($pattern, $string, $limit, $flags);

        return new static('', '', data: $data, readOnly: $readOnly);
    }

    /**
     * Static initializer for string with RegExp split pattern.
     *
     * @param  string    $string
     * @param  string    $pattern
     * @param  int|null  $limit
     * @param  int|null  $flags
     * @param  bool|null $readOnly
     * @return static
     * @throws froq\collection\CollectionException
     */
    public static final function splitRegExp(string $string, string $pattern, int $limit = null, int $flags = null,
        bool $readOnly = null): static
    {
        try {
            $regx = \RegExp::fromPattern($pattern, throw: true);
            $data = $regx->split($string, $limit ?? -1, $flags ?? 0);

            return new static('', '', data: $data, readOnly: $readOnly);
        } catch (\RegExpError $e) {
            throw new CollectionException($e->getMessage(), code: $e->getCode(), cause: $e);
        }
    }

    // @keep
    // private static function initStatic(array $data): static
    // {
    //     return new class($data) extends SplitCollection {
    //         public function __construct($data) {
    //             $this->data = $data;
    //         }
    //     };
    // }
}
