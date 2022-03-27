<?php

/**
 * The actual product object; has a name, price and quantity
 * This product can be interpret as a stack; therefore it also has a quantity
 */
class Product
{
    private $name;
    private $price;
    private $qty;

    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
        $this->qty = 1;
    }

    /**
     * Returns the name of the product
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * Returns the price of the product
     */
    function getPrice()
    {
        return $this->price;
    }

    /**
     * Returns the number of products in this stack
     */
    function getQty()
    {
        return $this->qty;
    }

    /**
     * Set the new number of products in this stack
     */
    function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * Add a number of products to the existing stack
     */
    function addQty($qty)
    {
        $this->qty += $qty;
    }
}
