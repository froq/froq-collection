<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\iterator;

use froq\collection\trait\{SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, HasTrait};
use froq\common\interface\{Listable, Arrayable, Objectable, Jsonable};
use froq\common\trait\{DataCountTrait, DataEmptyTrait, DataToListTrait, DataToArrayTrait, DataToObjectTrait,
    DataToJsonTrait, DataIteratorTrait, ReadOnlyTrait};
use froq\util\Util;

/**
 * Abstract Iterator.
 *
 * An abstract iterator class that used by iterator classes.
 *
 * @package froq\collection\iterator
 * @object  froq\collection\iterator\AbstractIterator
 * @author  Kerem Güneş
 * @since   5.3, 6.0
 */
abstract class AbstractIterator implements IteratorInterface, Listable, Arrayable, Objectable, Jsonable,
    \Iterator, \Countable, \JsonSerializable
{
    /**
     * @see froq\collection\trait\SortTrait
     * @see froq\collection\trait\EachTrait
     * @see froq\collection\trait\FilterTrait
     * @see froq\collection\trait\MapTrait
     * @see froq\collection\trait\ReduceTrait
     * @see froq\collection\trait\HasTrait
     */
    use SortTrait, EachTrait, FilterTrait, MapTrait, ReduceTrait, HasTrait;

    /**
     * @see froq\common\trait\DataCountTrait
     * @see froq\common\trait\DataEmptyTrait
     * @see froq\common\trait\DataToListTrait
     * @see froq\common\trait\DataToArrayTrait
     * @see froq\common\trait\DataToObjectTrait
     * @see froq\common\trait\DataToJsonTrait
     * @see froq\common\trait\DataIteratorTrait
     */
    use DataCountTrait, DataEmptyTrait, DataToListTrait, DataToArrayTrait, DataToObjectTrait, DataToJsonTrait,
        DataIteratorTrait;

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
            $data = Util::makeArray($data, deep: false);
            $this->data = $data;
        }

        $this->readOnly($readOnly);
    }

    /** @magic */
    public function __debugInfo(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
