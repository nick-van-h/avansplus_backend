<?php

/**
 * The shopping list that the customer carries with him/her
 * Products can be added to the shopping list following the Product class
 */
class ShoppingList
{
    private $products;

    function __construct()
    {
        $this->products = [];
    }

    function addProduct(Product $newProduct)
    {
        /**
         * Check if there are any products in the list already
         * If so, go over the list and check if the product matches the new product
         */
        if (count($this->products)) {
            foreach ($this->products as $product) {
                //To test: Can we compare on class level?
                if ($product->getName() == $newProduct->getName()) {
                    $product->addQty($newProduct->getQty());
                    return;
                }
            }
        }

        /**
         * Fallthrough;
         * If at this point the code did not return, it means
         * the product is not on the shopping list yet
         * Add it as a new member to the array
         */
        $this->products[] = clone $newProduct;
    }

    /**
     * For debugging, show the contents of the shopping list pre-formatted
     */
    function showContents()
    {
        echo ('<pre>');
        print_r($this->products);
        echo ('</pre>');
    }

    /**
     * Clear all items from the shopping list, i.e. assinging an empty array to the products variable
     */
    function clear()
    {
        $this->products = [];
    }

    /**
     * Returns the first item on the shopping list
     * Then removes this item from the list (using array_shift)
     */
    function getNextItem()
    {
        if (count($this->products)) {
            /**
             * Get the first item from the list, then
             * Shift the array to remove the first item
             */
            $item = $this->products[0];
            array_shift($this->products);
            return $item;
        } else {
            //There are no items left on the shopping list
            return false;
        }
    }

    /**
     * Returns true if there are items on the shopping list
     */
    function hasItems()
    {
        return (count($this->products) > 0);
    }
}
