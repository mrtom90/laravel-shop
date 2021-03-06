<?php namespace Mrtom90\LaravelShop\Cart;

/**
 * Created by PhpStorm.
 * User: darryl
 * Date: 1/17/2015
 * Time: 11:03 AM
 */

use Illuminate\Support\Collection;

/**
 * @property mixed|null price
 * @property mixed|null quantity
 * @property mixed|null conditions
 */
class ItemCollection extends Collection
{

    /**
     * get the sum of price
     *
     * @return mixed|null
     */
    public function getPriceSum()
    {
        return $this->price * $this->quantity;
    }

    public function getQuantitySum()
    {
        return $this->quantity;
    }

    public function __get($name)
    {
        if ($this->has($name)) return $this->get($name);
        return null;
    }

    /**
     * check if item has conditions
     *
     * @return bool
     */
    public function hasConditions()
    {
        if (!isset($this['conditions'])) return false;
        if (is_array($this['conditions'])) {
            return count($this['conditions']) > 0;
        }
        $conditionInstance = "Mrtom90\\LaravelShop\\Cart\\CartCondition";
        if ($this['conditions'] instanceof $conditionInstance) return true;

        return false;
    }

    /**
     * get the single price in which conditions are already applied
     *
     * @param bool $multipleByQuantity
     * @return mixed|null
     */
    public function getPriceWithConditions($multipleByQuantity = false)
    {
        if ($multipleByQuantity) {
            $originalPrice = $this->price * $this->quantity;
        } else {
            $originalPrice = $this->price;
        }

        $newPrice = 0.00;
        $processed = 0;

        if ($this->hasConditions()) {
            if (is_array($this->conditions)) {
                foreach ($this->conditions as $condition) {
                    if ($condition->getTarget() === 'item') {
                        ($processed > 0) ? $toBeCalculated = $newPrice : $toBeCalculated = $originalPrice;
                        $newPrice = $condition->applyCondition($toBeCalculated);
                        $processed++;
                    }
                }
            } else {
                if ($this['conditions']->getTarget() === 'item') {
                    $newPrice = $this['conditions']->applyCondition($originalPrice);
                }
            }

            return $newPrice;
        }
        return $originalPrice;
    }

    /**
     * get the sum of price in which conditions are already applied
     *
     * @return mixed|null
     */
    public function getPriceSumWithConditions()
    {

        return $this->getPriceWithConditions(true);
        //return $this->getPriceWithConditions() * $this->quantity;

    }


    public function getConditionsSum()
    {

        return $this->getPriceWithConditions(true) - $this->getPriceSum();
        //return $this->getPriceWithConditions() * $this->quantity;

    }

    /**
     * get the single price in which conditions are already applied
     *
     * @param string $type
     * @return mixed|null
     * @internal param bool $multipleByQuantity
     */
    public function getConditionsSumByType($type = 'shipping')
    {
        $originalPrice = 0;

        $newPrice = 0.00;
        $processed = 0;

        if ($this->hasConditions()) {
            if (is_array($this->conditions)) {
                foreach ($this->conditions as $condition) {
                    if ($condition->getTarget() === 'item' && $condition->getType() == $type) {
                        ($processed > 0) ? $toBeCalculated = $newPrice : $toBeCalculated = $originalPrice;
                        $newPrice = $condition->applyCondition($toBeCalculated);
                        $processed++;
                    }
                }
            } else {
                if ($this['conditions']->getTarget() === 'item' && $this['conditions']->getType() == $type) {
                    $newPrice = $this['conditions']->applyCondition($originalPrice);
                }
            }

            return $newPrice;
        }
        return $originalPrice;
    }

}
