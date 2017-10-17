<?php

require __DIR__  . '/src/SplClassLoader.php';

$oClassLoader = new \SplClassLoader('Lpp', __DIR__ . '/src');
$oClassLoader->register();
$brandService = new Lpp\Service\BrandService();
$brands = $brandService->getResultForCollectionId('1315475');
var_dump($brands);
$validator = new Lpp\Helper\Validator();
$item = new Lpp\Entity\Item();
$item->url = "http://www.lpp.pl";

if($validator->validateItem($item)) {
    echo "Its correct Item with correct URL";
} else {
    echo "Its not correct item";
}
$itemService = new Lpp\Service\ItemService();
$items = $itemService->getItemsForCollection('winter');

var_dump($items);
