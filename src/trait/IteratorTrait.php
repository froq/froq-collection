<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * A trait, provides related methods for the classes implementing `Iterator` interface.
 *
 * Note: While iterating a user object of this trait and key / index access needed in a
 * loop (eg: to get "next" or "prev" item), a copy of this object (clone) should be used,
 * instead of making look ups like:
 *
 * Bad usage:
 * ```
 * foreach ($iter as $i => $curr)
 *   $next = $iter[$i+1];
 * ```
 *
 * Good usage:
 *```
 * $copy = clone $iter;
 * foreach ($iter as $i => $curr)
 *   $next = $copy[$i+1];
 *  ```
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\IteratorTrait
 * @author  Kerem Güneş
 * @since   5.10, 6.0
 */
trait IteratorTrait
{
    /** @internal */
    private int $__pointer = 0;

    /** @inheritDoc Iterator */
    public function rewind(): void
    {
        $this->__pointer = count($this->data);

        reset($this->data);
    }

    /** @inheritDoc Iterator */
    public function valid(): bool
    {
        return $this->__pointer > 0;

        // @cancel: Since key() does NOT move the pointer,
        // relying on this causes live-lock (recursions) in
        // foreach() blocks, when this kind of usage present:
        // foreach ($iter as $i => $value) { $next = $iter[$i+1]; }
        // return key($this->data) !== null;
    }

    /** @inheritDoc Iterator */
    public function next(): void
    {
        $this->__pointer--;

        next($this->data);
    }

    /** @inheritDoc Iterator */
    public function key(): int|string|null
    {
        return key($this->data);
    }

    /** @inheritDoc Iterator */
    public function current(): mixed
    {
        return current($this->data);
    }

    /** @alias current() */
    public function value()
    {
        return $this->current();
    }

    /** @alias rewind() */
    public function reset()
    {
        $this->rewind();
    }
}
