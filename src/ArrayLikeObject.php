<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\ArrayObject;
use froq\collection\trait\AccessMagicTrait;

/**
 * Array-like Object.
 *
 * Represents an array-object structure with dynamic access/modify methods and other inherit utilities.
 *
 * @package froq\collection
 * @object  froq\collection\ArrayLikeObject
 * @author  Kerem Güneş
 * @since   5.15
 */
class ArrayLikeObject extends ArrayObject
{
    /** @see froq\collection\trait\AccessMagicTrait */
    use AccessMagicTrait;
}
