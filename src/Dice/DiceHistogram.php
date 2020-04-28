<?php

namespace Lioo19\Dice;

/**
 * A dice which has the ability to present data to be used for creating
 * a histogram.
 */
class DiceHistogram extends DiceGame implements HistogramInterface
{
    use HistogramTrait;

    /**
    * @var array $allRolled all values in gameRound
    */
    protected $allRolled;


    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax()
    {
        return $this->max;
    }

    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin()
    {
        return $this->min;
    }

    /**
     * Set Serie
     * Since serie should be for entire round, adding
     *
     * @return int with the max value.
     */
    public function setSerie(array $add)
    {
        $this->serie = array_merge($this->serie, $add);
    }
}
