<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection\object;

use froq\collection\trait\AccessMagicTrait;
use stdClass;

/**
 * Array-like Object.
 *
 * An array-object structure with dynamic access/modify methods and other inherit utilities.
 *
 * @package froq\collection\object
 * @object  froq\collection\object\ArrayLikeObject
 * @author  Kerem Güneş
 * @since   5.15
 */
class ArrayLikeObject extends ArrayObject
{
    /** @see froq\collection\trait\AccessMagicTrait */
    use AccessMagicTrait;

    /**
     * Constructor.
     *
     * @param array<int|string, any>|stdClass|null $data
     * @param bool|null                            $readOnly
     */
    public function __construct(array|stdClass $data = null, bool $readOnly = null)
    {
        if ($data && $data instanceof stdClass) {
            $data = get_object_vars($data);
        }

        parent::__construct($data, $readOnly);
    }
}
