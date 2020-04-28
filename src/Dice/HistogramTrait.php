<?php

namespace Lioo19\Dice;

/**
* Trait for implementing histogramInterface
*
*/
trait HistogramTrait
{
    /**
    * @var array $serie The numbers stored in sequence
    */
    private $serie = [];
    private $min;
    private $max;

    /**
    * Get serie
    *
    *@return array within the $serie var
    */
    public function getHistogramSerie()
    {
        return $this->serie;
    }

    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function setHistogramMax(int $max)
    {
        $this->max = $max;
    }

    /**
     * Get max value for the histogram.
     *
     * @return int with the max value.
     */
    public function setHistogramMin(int $min)
    {
        $this->min = $min;
    }

    /**
    * Print out the histogram, default to only print the acutal numbers
    * thrown, but when $min and $max is set, then also print the numbers
    * not thrown, within given range.
    *
    * @param int $min The lowest possible number to throw
    * @param int $max The highest possible number to throw
    *
    * @return string representing histogram
    */
    public function printHistogram(int $max, int $min = 1)
    {
        // if ($max == null) {
        //     return null;
        // }
        $this->setHistogramMax($max);
        $this->setHistogramMin($min);
        $sortedSerie = [];
        //Sorting the list of possible values
        for ($i= $this->min; $i <= $this->max; $i++) {
            $sortedSerie += [$i => 0];
        }
        //loop that goes through the dice-values and adds them to the sortedSerie
        foreach ($this->serie as $value) {
            if (isset($sortedSerie[$value])) {
                $sortedSerie[$value]++;
            }
        }
        // print_r($sortedSerie);
        // return $sortedSerie;
        return $this->histogramHTML($sortedSerie);
    }


    /**
    * HTML-code for histogram
    *
    * @return string with html-code
    */
    public function histogramHTML(array $sortedSerie)
    {
        $histogramHTML = '<ul style="list-style-type:none">';
        foreach ($sortedSerie as $key => $value) {
            $histogramHTML .= '<li>' . $key . '. ';
            for ($i=0; $i < $value; $i++) {
                $histogramHTML .= '*';
            }
            $histogramHTML .= '</li>';
        }
        $histogramHTML .= '</ul>';

        return $histogramHTML;
    }
}
