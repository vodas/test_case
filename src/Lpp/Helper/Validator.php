<?php

namespace Lpp\Helper;

use Lpp\Entity\Item;

/**
 * Class Validator
 * @package Lpp\Helper
 */
class Validator
{
    /**
     * @param $item
     * @return bool
     */
    public function validateItem($item) {

        //check if given class is correct instance
        if (!($item instanceof Item)) {
            return false;
        }

        //check that property url exists
        if (!property_exists($item, 'url')) {
            return false;
        }

        //check that url is not empty
        if (null === $item->url || '' == $item->url) {
            return false;
        }

        //check that url is correct
        if (!filter_var($item->url, FILTER_VALIDATE_URL)) {
            return false;
        }

        return true;
    }
}
