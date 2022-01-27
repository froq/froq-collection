<?php
/**
 * Copyright (c) 2015 · Kerem Güneş
 * Apache License 2.0 · http://github.com/froq/froq-collection
 */
declare(strict_types=1);

namespace froq\collection;

/**
 * Weighted Collection.
 *
 * Represents a weighted array structure that utilizes items selection operations by their weights.
 *
 * @package froq\collection
 * @object  froq\collection\WeightedCollection
 * @author  Kerem Güneş
 * @since   4.0
 */
class WeightedCollection extends AbstractCollection implements CollectionInterface
{
    /**
     * Constructor.
     *
     * @param array<int|string, any>|null $data
     * @param bool|null                   $readOnly
     */
    public function __construct(array $data = null, bool $readOnly = null)
    {
        parent::__construct($data, $readOnly);
    }

    /**
     * Select items by default.
     *
     * @return array|null
     */
    public final function select(): array|null
    {
        return $this->selectBy(null, null);
    }

    /**
     * Select items (by optionally given min-weight / max-weight).
     *
     * @param  float|null $minWeight
     * @param  float|null $maxWeight
     * @return array|null
     */
    public final function selectBy(float $minWeight = null, float $maxWeight = null): array|null
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
     * Filter self data items by given callback.
     *
     * @param  callable $calback
     * @return array|null
     */
    private function filterize(callable $calback): array|null
    {
        $items = array_filter($this->data, $calback);
        $count = count($items);

        if ($count == 0) return null;
        if ($count == 1) return $items[0];

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
     * Get a random number by given min/max directives.
     *
     * @param  float $min
     * @param  float $max
     * @return float
     */
    private function randomize(float $min, float $max): float
    {
        return lcg_value() * ($max - $min) + $min;
    }
}
