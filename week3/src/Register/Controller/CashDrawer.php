<?php

/**
 * The cash drawer extends the payment device
 * Specific property of the cash drawer is that it returns change based on the balance
 */
class CashDrawer extends PaymentDevice
{
    function __construct(ShoppingCart $shoppingCart)
    {
        parent::__construct($shoppingCart);
    }

    /**
     * Make the payment according to the base class
     * Then calculate the change if the payment was succesful
     */
    function makePayment($balance)
    {
        parent::makePayment($balance);
        if ($this->shoppingCart->isStatusSuccess()) {
            $this->shoppingCart->setChange($balance - $this->shoppingCart->getGrandTotal());
        }
    }
}
