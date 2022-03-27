<?php

/**
 * The scanner is quite dumb, the only thing it can do is scan a new product
 * The only magical thing about it is that it can somehow guess how many
 * items of the same product the customer is holding at that time
 * (spoiler: this is because the product class contains a qty) 
 */

class Scanner
{
    private $shoppingCart;

    function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Add a product to the shopping list
     */
    function scanProduct(Product $newProduct)
    {
        $this->shoppingCart->addProduct($newProduct);
    }
}
