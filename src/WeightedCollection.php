<?php declare(strict_types=1);
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
namespace froq\collection;

/**
 * A weighted-array class, utilizes item selection operations by their weights.
 *
 * @package froq\collection
 * @class   froq\collection\WeightedCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class WeightedCollection extends AbstractCollection
{
    /**
     * Select items by default.
     *
     * @return array|null
     */
    public function select(): array|null
    {
        return $this->selectBy(null, null);
    }

    /**
     * Select items (by optionally given min/max weight).
     *
     * @param  int|float|null $minWeight
     * @param  int|float|null $maxWeight
     * @return array|null
     */
    public function selectBy(int|float $minWeight = null, int|float $maxWeight = null): array|null
    {
        return $this->filterize(function ($item) use ($minWeight, $maxWeight) {
            // There is nothing to do without a "weight" field.
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
     * Filter self data items by given callback.
     */
    private function filterize(callable $filter): array|null
    {
        $items = filter($this->data, $filter);
        $count = count($items);

        if ($count === 0) return null;
        if ($count === 1) return $items[0];

        $totalWeight = 0.0;
        foreach ($items as $item) {
            $totalWeight += (float) $item['weight'];
        }

        // No total weight, no items to select.
        if (!$totalWeight) {
            return null;
        }

        $accWeight = 0.0;
        $ranWeight = $this->randomize(0.0, $totalWeight);

        foreach ($items as $item) {
            $accWeight += (float) $item['weight'];
            if ($accWeight >= $ranWeight) {
                break;
            }
        }

        return $item;
    }

    /**
     * Get a random number by given min/max directives.
     */
    private function randomize(float $min, float $max): float
    {
        return lcg_value() * ($max - $min) + $min;
    }
}
