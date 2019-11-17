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
 * Weighted Collection.
 *
 * Represents a weighted array structure that utilizes items selection operations by theirs
 * weights.
 *
 * @package froq\collection
 * @object  froq\collection\WeightedCollection
 * @author  Kerem Güneş <k-gun@mail.com>
 * @since   4.0
 */
class WeightedCollection extends AbstractCollection
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
     * Select.
     * @return ?array
     */
    public final function select(): ?array
    {
        return $this->selectBy(null, null);
    }

    /**
     * Select by.
     * @param  float|null $minWeight
     * @param  float|null $maxWeight
     * @return ?array
     */
    public final function selectBy(float $minWeight = null, float $maxWeight = null): ?array
    {
        return $this->filter(function ($item) use ($minWeight, $maxWeight) {
            // There is nothing to do without weight.
            if (!is_array($item) || !isset($item['weight'])) {
                return false;
            }

            $weight = (float) $item['weight'];
            if ($minWeight && $weight < $minWeight) {
                return false;
            }
            if ($maxWeight && $weight > $maxWeight) {
                return false;
            }

            return true;
        });
    }

    /**
     * Filter.
     * @param  callable $calback
     * @return ?array
     */
    private final function filter(callable $calback): ?array
    {
        $items = array_filter($this->data, $calback);
        $itemsCount = count($items);

        if ($itemsCount == 0) return null;
        if ($itemsCount == 1) return $items[0];

        $totalWeight = 0.00;
        foreach ($items as $item) {
            $totalWeight += (float) $item['weight'];
        }

        // No total weight no items to select.
        if ($totalWeight == 0.00) {
            return null;
        }

        $accWeight = 0.00;
        $rndWeight = $this->rand(0.00, $totalWeight);

        foreach ($items as $item) {
            $accWeight += (float) $item['weight'];
            if ($accWeight >= $rndWeight) {
                break;
            }
        }

        return $item;
    }

    /**
     * Rand.
     * @param  float $min
     * @param  float $max
     * @return float
     */
    private final function rand(float $min, float $max): float
    {
        return lcg_value() * ($max - $min) + $min;
    }
}
