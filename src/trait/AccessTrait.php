<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection\trait;

/**
 * A trait, provides related methods for the classes implementing `ArrayAccess` interface
 * and defining `set()`, `get() and `remove()` methods.
 *
 * @package froq\collection\trait
 * @class   froq\collection\trait\AccessTrait
 * @author  Kerem Güneş
 * @since   4.0, 5.4
 */
trait AccessTrait
{
    /** @internal */
    private int|null $__indexer = null;

    /** @internal */
    private function __getMaxIndex(): int|null
    {
        if (isset($this->data)) {
            $keys = array_keys($this->data);
            $keys = array_filter($keys, 'is_int');
            return max($keys ?: [0]);
        }
        return null;
    }

    /** @inheritDoc ArrayAccess */
    public function offsetExists(mixed $key): bool
    {
        return $this->get($key) !== null;
    }

    /** @inheritDoc ArrayAccess */
    public function offsetSet(mixed $key, mixed $value): void
    {
        // Calls like `items[] = item`.
        if ($key === null) {
            $this->__indexer ??= $this->__getMaxIndex();
            $key = $this->__indexer++;
        }

        $this->set($key, $value);
    }

    /** @inheritDoc ArrayAccess */
    public function &offsetGet(mixed $key): mixed
    {
        // Calls like `items[][] = item`.
        // It does NOT maintain negative indexes.
        if ($key === null) {
            $this->__indexer ??= $this->__getMaxIndex();
            $key = $this->__indexer++;
        }

        return $this->get($key);
    }

    /** @inheritDoc ArrayAccess */
    public function offsetUnset(mixed $key): void
    {
        $this->remove($key);
    }
}
