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

namespace froq\collection\items;

use froq\collection\AbstractCollection;
use froq\collection\items\ItemsException;

/**
 * Items.
 *
 * Represents a simple array structure that inspired by DOMTokenList of JavaScript.
 *
 * @package froq\collection\items
 * @object  froq\collection\items\Items
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class Items extends AbstractCollection
{
    /**
     * Constructor.
     * @param array<int, any>|null $data
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            foreach (array_keys($data) as $key) {
                if (!is_int($key)) {
                    throw new ItemsException('Only int keys accepted for "%s" class',
                        [static::class]);
                }
            }
        }

        parent::__construct($data);
    }

     /**
     * Item.
     * @param  int $index
     * @return any|null
     */
    public final function item(int $index)
    {
        return $this->data[$index] ?? null;
    }

    /**
     * Items.
     * @return array<int, any>
     */
    public final function items(): array
    {
        return $this->data;
    }

    /**
     * Has.
     * @param  int $index
     * @return bool
     */
    public final function has(int $index): bool
    {
        return isset($this->data[$index]);
    }

    /**
     * Add.
     * @param  any $item
     * @return self
     */
    public final function add($item): self
    {
        $this->data[] = $item;

        return $this;
    }

    /**
     * Remove.
     * @param  int $index
     * @return self
     */
    public final function remove(int $index): self
    {
        unset($this->data[$index]);

        return $this;
    }
}
