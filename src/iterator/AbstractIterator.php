<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\trait\{SortTrait, FilterTrait, MapTrait, ReduceTrait, EachTrait, CountTrait, EmptyTrait, HasTrait,
    CalcAverageTrait, CalcProductTrait, CalcSumTrait, IteratorTrait, ToArrayTrait, ToObjectTrait, ToListTrait, ToJsonTrait};
use froq\common\interface\{Listable, Arrayable, Objectable, Jsonable};
use froq\common\trait\ReadOnlyTrait;
use froq\util\Util;

/**
 * Abstract Iterator.
 *
 * An abstract iterator class, extended by iterator classes.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\AbstractIterator
 * @author  Kerem Güneş
 * @since   5.3, 6.0
 */
abstract class AbstractIterator implements IteratorInterface, Arrayable, Objectable, Listable, Jsonable,
    \Iterator, \Countable, \JsonSerializable
{
    /** @see froq\common\trait\*Trait */
    use SortTrait, FilterTrait, MapTrait, ReduceTrait, EachTrait, CountTrait, EmptyTrait, HasTrait,
        CalcAverageTrait, CalcProductTrait, CalcSumTrait, IteratorTrait, ToArrayTrait, ToObjectTrait, ToListTrait, ToJsonTrait;

    /** @see froq\common\trait\ReadOnlyTrait */
    use ReadOnlyTrait;

    /** @var array */
    protected array $data = [];

    /**
     * Constructor.
     *
     * @param iterable  $data
     * @param bool|null $readOnly
     */
    public function __construct(iterable $data, bool $readOnly = null)
    {
        if ($data) {
            $this->data = (
                is_array($data) ? $data
                    : Util::makeArray($data, deep: false)
            );
        }

        $this->readOnly($readOnly);
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
