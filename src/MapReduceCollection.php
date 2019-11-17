<?php
/**
 * MIT License <https://opensource.org/licenses/mit>
 *
 * Copyright (c) 2015 Kerem Güneş
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is furnished
 * to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AbstractCollection;

/**
 * Map Reduce Collection.
 * @package froq\collection
 * @object  froq\collection\MapReduceCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class MapReduceCollection extends AbstractCollection
{
    /**
     * Constructor.
     * @param array|null $data
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);
    }

    /**
     * Map.
     * @param  callable $callback
     * @return static
     */
    public final function map(callable $callback)
    {
        return new static(array_map($callback, $this->data));
    }

    /**
     * Filter.
     * @param  callable $callback
     * @return static
     */
    public final function filter(callable $callback)
    {
        return new static(array_filter($this->data, $callback));
    }

    /**
     * Reduce.
     * @param  any|null $initialValue
     * @param  callable $callback
     * @return any
     */
    public final function reduce($initialValue = null, callable $callback)
    {
        return array_reduce($this->data, $callback, $initialValue);
    }
}
