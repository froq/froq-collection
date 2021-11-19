<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\trait;

/**
 * Read-Only Call Trait.
 *
 * Represents a read-only state check call trait that provides read-only call method if
 * the user class has `readOnlyCheck()` method (defined in `ReadOnlyTrait` trait).
 *
 * @package froq\collection\trait
 * @object  froq\collection\trait\ReadOnlyCallTrait
 * @author  Kerem Güneş
 * @since   5.4
 */
trait ReadOnlyCallTrait
{
    /**
     * Call read-only state check method if the user class has the checker method.
     *
     * @return void
     * @causes froq\common\exception\ReadOnlyException
     */
    public final function readOnlyCall(): void
    {
        // Might not be exists for all user class.
        if (method_exists($this, 'readOnlyCheck')) {
            $this->readOnlyCheck();
        }
    }
}
