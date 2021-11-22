<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\CollectionInterface;
use froq\common\object\XArray;

/**
 * Abstract Collection.
 *
 * @package froq\collection
 * @object  froq\collection\AbstractCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
abstract class AbstractCollection extends XArray implements CollectionInterface
{}
