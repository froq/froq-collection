<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\collator;

use froq\collection\trait\{AccessTrait, AccessMagicTrait, GetTrait};
use froq\common\object\XArray;
use ArrayAccess;

/**
 * Abstract Collator.
 *
 * Represents an collator class that provides more basic methods than collaction classes
 * and is extended by other collator classes.
 *
 * @package froq\collection\collator
 * @object  froq\collection\collator\AbstractCollator
 * @author  Kerem Güneş
 * @since   5.17
 */
abstract class AbstractCollator extends XArray implements ArrayAccess
{
    /**
     * @see froq\collection\trait\AccessTrait
     * @see froq\collection\trait\AccessMagicTrait
     * @see froq\collection\trait\GetTrait
     */
    use AccessTrait, AccessMagicTrait, GetTrait;
}
