<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\collector;

use froq\collection\trait\ArrayTrait;
use froq\common\interface\{Arrayable, Objectable, Listable, Jsonable, Iteratable, IteratableReverse};
use froq\common\trait\ReadOnlyTrait;
use froq\util\Util;

/**
 * Abstract collector class.
 *
 * @package froq\collection\collector
 * @class   froq\collection\collector\AbstractCollector
 * @author  Kerem Güneş
 * @since   5.17, 6.0
 */
abstract class AbstractCollector implements Arrayable, Objectable, Listable, Jsonable, Iteratable, IteratableReverse,
    \Iterator, \Countable, \JsonSerializable
{
    use CollectorTrait, ArrayTrait, ReadOnlyTrait;

    /** Data. */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable|null $data
     * @param bool|null     $readOnly
     */
    public function __construct(iterable $data = null, bool $readOnly = null)
    {
        if ($data) {
            if (is_iterator($data)) {
                $data = Util::makeArray($data, deep: false);
            }

            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }

        $this->readOnly($readOnly);
    }
}
