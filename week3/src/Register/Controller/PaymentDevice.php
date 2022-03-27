<?php

/**
 * An abstract payment device, which can be used to make a basic payment
 * It checks if the balance is sufficient to make the payment and set the status accordingly
 */
abstract class PaymentDevice
{
    protected $shoppingCart;

    function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Make the payment and set the status in the Model accordingly
     * If the balance is sufficient ( >= grand total ) then the payment is successful
     * else ( < grand total ) the payment failed
     */
    function makePayment($balance)
    {
        if ($this->shoppingCart->getGrandTotal() > $balance) {
            $this->shoppingCart->setStatusPaymentFailed("Insufficient balance");
        } else {
            $this->shoppingCart->setStatusPaymentSuccess();
        }
    }
}
