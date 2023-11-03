<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\iterator;

use froq\common\interface\{Arrayable, Listable};
use froq\util\Util;

/**
 * An extended `ArrayIterator` class.
 *
 * @package froq\collection\iterator
 * @class   froq\collection\iterator\ArrayIterator
 * @author  Kerem Güneş
 * @since   5.3
 */
class ArrayIterator extends \ArrayIterator implements Arrayable, Listable, \JsonSerializable
{
    /**
     * @override
     */
    public function __construct(iterable $data = [])
    {
        $data && $data = (
            is_array($data) ? $data
                : Util::makeArray($data, deep: false)
        );

        parent::__construct($data);
    }

    /**
     * Sort.
     *
     * @param  int|null  $func
     * @param  int       $flags
     * @param  bool|null $assoc
     * @return self
     */
    public function sort(callable|int $func = null, int $flags = 0, bool $assoc = null): self
    {
        if ($data = $this->toArray()) {
            $data = array_sort($data, $func, $flags, $assoc);

            // The only way to replace data so far.
            parent::__construct($data);
        }

        return $this;
    }

    /**
     * Slice (useful for after-sort calls).
     *
     * @param  int      $start
     * @param  int|null $end
     * @param  bool     $keepKeys
     * @return self
     */
    public function slice(int $start, int $end = null, bool $keepKeys = false): self
    {
        if ($data = $this->toArray()) {
            $data = array_slice($data, $start, $end, $keepKeys);

            // The only way to replace data so far.
            parent::__construct($data);
        }

        return $this;
    }

    /**
     * Reverse.
     *
     * @param  bool $keepKeys
     * @return self
     */
    public function reverse(bool $keepKeys = false): self
    {
        if ($data = $this->toArray()) {
            $data = array_reverse($this->toArray(), $keepKeys);

            // The only way to replace data so far.
            parent::__construct($data);
        }

        return $this;
    }

    /**
     * @override
     */
    public function append(mixed ...$items): self
    {
        foreach ($items as $item) {
            parent::append($item);
        }

        return $this;
    }

    /**
     * @inheritDoc froq\common\interface\Arrayable
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }

    /**
     * @inheritDoc froq\common\interface\Listable
     */
    public function toList(): array
    {
        return array_list($this->toArray());
    }

    /**
     * @inheritDoc JsonSerializable
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
