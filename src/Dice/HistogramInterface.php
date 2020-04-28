<?php

namespace Lioo19\Dice;

/**
* A interface for a classes supporting histogram reports.
*/
interface HistogramInterface
{
    /**
    * Get the serie
    *
    * @return array with serie
    */
    public function getHistogramSerie();


    /**
     * Get min value for the histogram.
     *
     * @return int with the min value.
     */
    public function getHistogramMin();


    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function getHistogramMax();
}
