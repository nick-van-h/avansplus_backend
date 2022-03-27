<?php

/**
 * The cash drawer extends the payment device
 * Specific property of the pin device is that it has a reliability
 */
class PinDevice extends PaymentDevice
{
    private $reliability;

    function __construct(ShoppingCart $shoppingCart)
    {
        parent::__construct($shoppingCart);
        $this->reliability = rand(95, 99);
    }

    /**
     * Try to make a payment based on the reliability (through random number)
     * If the pin device works then the payment is made, else the payment fails
     */
    function makePayment($balance)
    {
        if (rand(0, 100) > (100 - $this->reliability)) {
            parent::makePayment($balance);
        } else {
            $this->shoppingCart->setStatusPaymentFailed("Pin device crashed");
        }
    }

    /**
     * For test case; manually set the reliability
     */
    function overwriteReliability($reliability)
    {
        $this->reliability = $reliability;
    }
}
