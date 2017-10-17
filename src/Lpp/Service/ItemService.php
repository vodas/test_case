<?php

namespace Lpp\Service;

use Lpp\Entity\Brand;
use Lpp\Entity\Item;
use Lpp\Entity\Price;
use Lpp\Service\BrandService;

/**
 * Class ItemService
 * @package Lpp\Service
 */
class ItemService implements ItemServiceInterface
{

    /**
     * @var ItemServiceInterface
     */
    private $itemService;

    /**
     * Maps from collection name to the id for the item service.
     *
     * @var []
     */
    private $collectionNameToIdMapping = [
        "winter" => 1314575
    ];

    /**
     * @param string $collectionName
     * @return array
     */
    public function getItemsForCollection($collectionName)
    {
        $collectionId = $this->collectionNameToIdMapping[$collectionName];
        $itemsArray = [];
        $brandService = new BrandService();
        $brands = $brandService->getResultForCollectionId($collectionId);
        foreach ($brands as $brand) {
            foreach ($brand->items as $item) {
                $itemsArray[] = $item;
            }
        }
        $this->sortItemsByName($itemsArray);
        return $itemsArray;
    }

    /**
     * @param ItemServiceInterface $itemService
     */
    public function setItemService(ItemServiceInterface $itemService) {
        $this->itemService = $itemService;
    }

    /**
     * @param $itemsArray
     * @return mixed
     */
    public function sortItemsByName($itemsArray) {
        usort($itemsArray,function($first,$second){
            return strcmp($first->name, $second->name);
        });
        return $itemsArray;
    }

}
