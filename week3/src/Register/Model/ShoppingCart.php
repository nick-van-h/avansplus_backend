<?php

/**
 * The shopping cart is the model that contains all the products and keeps track of the checkout
 * Possible improvement point: Migrate the payment process to a separate class
 */
class ShoppingCart
{
    private $products = [];
    private $checkoutStatus;
    private $change = 0;
    private $statusMessage;

    private const STATUS_SCANNING = 1;
    private const STATUS_PAYMENT_FAILED = self::STATUS_SCANNING + 1;
    private const STATUS_PAYMENT_SUCCESS = self::STATUS_PAYMENT_FAILED + 1;

    function __construct()
    {
    }

    /**
     * Add a single product to the cart, following the Product class
     */
    function addProduct(Product $newProduct)
    {
        /**
         * Check if there are any products in the list already
         * If so, go over the list and check if any of the products in the cart matches the new product
         */
        if (count($this->products)) {
            foreach ($this->products as $product) {
                if ($product->getName() == $newProduct->getName()) {
                    /**
                     * There is already a product in the cart with the same name
                     * Increase the qty of the existing product with the qty of the new product
                     */
                    $product->addQty($newProduct->getQty());
                    return;
                }
            }
        }

        /**
         * Fallthrough;
         * If at this point the code did not return, it means
         * the product is not in the shopping cart yet
         * Add it as a new member to the array
         */
        $this->products[] = clone $newProduct;
    }

    /**
     * Returns the total array with all products
     */
    function getProducts()
    {
        return $this->products;
    }

    /**
     * Returns the total price for all products (qty*price) in the shopping cart
     */
    function getGrandTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += ($product->getQty() * $product->getPrice());
        }
        return $total;
    }

    /**
     * Get the total number of products in the shopping cart
     */
    function getTotalNumberOfProducts()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->getQty();
        }
        return $total;
    }

    /**
     * Set the status of the payment to failed
     * A reason why the payment failed is mandatory
     */
    function setStatusPaymentFailed($reason)
    {
        $this->checkoutStatus = self::STATUS_PAYMENT_FAILED;
        $this->statusMessage = $reason;
    }

    /**
     * Set the status of the payment to successful
     */
    function setStatusPaymentSuccess()
    {
        $this->checkoutStatus = self::STATUS_PAYMENT_SUCCESS;
    }

    /**
     * Returns true if the status is scanning
     */
    function isStatusScanning()
    {
        return $this->checkoutStatus == self::STATUS_SCANNING;
    }

    /**
     * Returns true if the payment status is failed
     */
    function isStatusFailed()
    {
        return $this->checkoutStatus == self::STATUS_PAYMENT_FAILED;
    }

    /**
     * Returns true if the payment status is successful
     */
    function isStatusSuccess()
    {
        return $this->checkoutStatus == self::STATUS_PAYMENT_SUCCESS;
    }

    /**
     * Set the change to be returned after payment
     */
    function setChange($change)
    {
        $this->change = $change;
    }

    /**
     * Get the change amount after payment
     */
    function getChange()
    {
        return $this->change;
    }

    /**
     * Return the payment status message
     */
    function getStatusMessage()
    {
        return $this->statusMessage;
    }
}
