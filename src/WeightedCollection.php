<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 <https://opensource.org/licenses/apache-2.0>
 */
declare(strict_types=1);

namespace froq\collection;

use froq\collection\AbstractCollection;

/**
 * Weighted Collection.
 *
 * Represents a weighted array structure that utilizes items selection operations by their weights.
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
        return $this->filterize(function ($item) use ($minWeight, $maxWeight) {
            // There is nothing to do without weight.
            if (!is_array($item) || !isset($item['weight'])) {
                return false;
            }

            $weight = (float) $item['weight'];
            if ($minWeight !== null && $weight < $minWeight) {
                return false;
            }
            if ($maxWeight !== null && $weight > $maxWeight) {
                return false;
            }

            return true;
        });
    }

    /**
     * Filterize.
     * @param  callable $calback
     * @return ?array
     */
    private function filterize(callable $calback): ?array
    {
        $items = array_filter($this->data, $calback);
        $itemsCount = count($items);

        if ($itemsCount == 0) return null;
        if ($itemsCount == 1) return $items[0];

        $totalWeight = 0.0;
        foreach ($items as $item) {
            $totalWeight += (float) $item['weight'];
        }

        // No total weight no items to select.
        if ($totalWeight == 0.0) {
            return null;
        }

        $accWeight = 0.0;
        $rndWeight = $this->randomize(0.0, $totalWeight);

        foreach ($items as $item) {
            $accWeight += (float) $item['weight'];
            if ($accWeight >= $rndWeight) {
                break;
            }
        }

        return $item;
    }

    /**
     * Randomize.
     * @param  float $min
     * @param  float $max
     * @return float
     */
    private function randomize(float $min, float $max): float
    {
        return lcg_value() * ($max - $min) + $min;
    }
}
