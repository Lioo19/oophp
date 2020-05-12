<?php

namespace Lioo19\Content;

/**
* Class with supporting functions
*
*/

class Support {
    /**
    * method for activating textfilters
    * @param $content string of content
    * @param $chosenFilters string of chosen filters
    */
    public function textFilter($content, $chosenFilters)
    {
        $textf = new \Lioo19\MyTextFilter\MyTextFilter();

        $chosenFilters = strtolower($chosenFilters);
        $chosenFiltersArray = explode(",", $chosenFilters);
        foreach ($chosenFiltersArray as $key => $value) {
            $value = trim($value);
        }
        
        $textRes = $textf->parse($content, $chosenFiltersArray);

        return $textRes;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }
}
