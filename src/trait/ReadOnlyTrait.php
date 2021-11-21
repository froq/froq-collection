<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

use froq\common\exception\ReadOnlyException;
use froq\util\Objects;

/**
 * Read-Only Trait.
 *
 * Represents a read-only state check trait that provides read-only utilities.
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ReadOnlyTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait ReadOnlyTrait
{
    /** @var array */
    private static array $__READ_ONLY_STATES;

    /**
     * Set/get read-only state.
     *
     * @param  bool|null $state
     * @return bool|null
     */
    public final function readOnly(bool $state = null): bool|null
    {
        $id = Objects::getId($this);

        return self::$__READ_ONLY_STATES[$id] ??= $state;
    }

    /**
     * Check read-only state, throw an exception if the user object is read-only.
     *
     * @return void
     * @throws froq\common\exception\ReadOnlyException
     */
    public final function readOnlyCheck(): void
    {
        $this->readOnly() && throw new ReadOnlyException(
            'Cannot modify read-only object ' . Objects::getId($this)
        );
    }

    /**
     * Get read-only states.
     *
     * @return array|null
     */
    public static final function readOnlyStates(): array|null
    {
        return self::$__READ_ONLY_STATES ?? null;
    }

    /**
     * Lock, read-only state as true.
     *
     * @return self
     */
    public final function lock(): self
    {
        $this->readOnly(true);

        return $this;
    }

    /**
     * Unlock, read-only state as false.
     *
     * @return self
     */
    public final function unlock(): self
    {
        $this->readOnly(false);

        return $this;
    }
}
