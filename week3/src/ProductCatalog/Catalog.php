<?php

/**
 * This class contains the complete catalog of products, as defined in the json
 * Possible improvement point: use an SQL database instead
 * This class can return a random product, or return a complete product following the Product class
 * based on a product name
 */
class Catalog
{
    private $productCatalog;
    private $products;

    function __construct()
    {
        /**
         * Construct an array of Product objects as defined in the json
         */
        $this->productCatalog = json_decode(file_get_contents(__DIR__ . '/ProductCatalog.json'), true);
        $this->products = [];

        foreach ($this->productCatalog as $product) {
            $this->products[] = new Product($product["Name"], $product["Price"]);
        }
    }

    /**
     * Returns a random product
     */
    function getRandomProduct()
    {
        $i = rand(0, count($this->productCatalog) - 1);
        return $this->products[$i];
    }

    /**
     * Returns a Product object if there is one with a matching name
     */
    function getProductByName($name)
    {
        foreach ($this->products as $product) {
            if ($product->getName() == $name) {
                return $product;
            }
        }
        return false;
    }
}
