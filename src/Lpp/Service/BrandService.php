<?php

namespace Lpp\Service;

use Lpp\Entity\Brand;
use Lpp\Entity\Item;
use Lpp\Entity\Price;

/**
 * Class BrandService
 * @package Lpp\Service
 */
class BrandService implements BrandServiceInterface
{
    const PATH_TO_FILE = __DIR__ . '/../../../data/1315475.json';

    /**
     * @param int $collectionId
     * @return array|null
     */
    public function getResultForCollectionId($collectionId) {

        if (!file_exists(self::PATH_TO_FILE)) {
            return null;
        }
        $fileContent = @file_get_contents(self::PATH_TO_FILE, FILE_USE_INCLUDE_PATH);
        $brandsArray = json_decode($fileContent, true);

        if(!$this->checkField('id', $brandsArray) || !$this->checkField('brands', $brandsArray)) {
            return null;
        }
        $returnBrandsArray = [];
        if($brandsArray['id'] == $collectionId) {
           $brands = $brandsArray['brands'];
           foreach ($brands as $brand) {
               $returnBrandsArray[] = $this->loadBrand($brand);
           }
           return $returnBrandsArray;
        }
        return null;
    }

    /**
     * @param $key
     * @param $array
     * @return bool
     */
    private function checkField($key, $array) {
        if(!array_key_exists($key, $array)) {
            return false;
        }
        return true;
    }

    /**
     * @param $brand
     * @return Brand
     */
    private function loadBrand($brand) {
        $newBrand = new Brand();
        $newBrand->brand = $brand['name'];
        $newBrand->description = $brand['description'];
        $itemsArray = [];
        foreach ($brand['items'] as $item) {
            $itemsArray[] = $this->loadItem($item);
        }
        $newBrand->items = $itemsArray;
        return $newBrand;
    }

    /**
     * @param $price
     * @return Price
     */
    private function loadPrice($price) {
        $newPrice = new Price();
        $newPrice->description = $price['description'];
        $newPrice->priceInEuro = $price['priceInEuro'];
        $newPrice->arrivalDate = $price['arrival'];
        $newPrice->dueDate = $price['due'];
        return $newPrice;
    }

    /**
     * @param $item
     * @return Item
     */
    private function loadItem($item) {
        $newItem = new Item();
        $newItem->name = $item['name'];
        $newItem->url = $item['url'];
        $pricesArray = [];
        foreach($item['prices'] as $price) {
            $pricesArray[] = $this->loadPrice($price);
        }
        $newItem->prices = $pricesArray;
        return $newItem;
    }
}
