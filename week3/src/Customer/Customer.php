<?php

/**
 * The actual customer that operates a cash register
 */
class Customer
{
    private $name;
    private $balance;
    private $shoppingList;
    private $paymentMethod;
    private $register = null;

    /**
     * Set the name, balance, shopping list and payment method when creating the customer
     */
    function __construct($name, $balance, ShoppingList $ShoppingList, $paymentMethod)
    {
        $this->name = $name;
        $this->balance = $balance;
        $this->shoppingList = $ShoppingList;
        $this->paymentMethod = $paymentMethod;

        //For storyline
        echo ('<h2>Customer: ' . $name . '</h2>');
    }

    /**
     * Move the customer to a register
     * I.e. creating a new register class and assigning it to the variable
     */
    function goToRegister()
    {
        $this->register = new Register();
    }

    /**
     * Leave the register, i.e. destroying the register class
     * Checks if the payment has been fulfilled before leaving
     */
    function leaveRegister()
    {
        if (!$this->register->paymentIsSuccesful()) {
            //For storyline
            echo ($this->name . ' left the store without fulfilling the payment, the cops have been called for shoplifting!');
            return;
        } else {
            //For storyline
            echo ("Thanks for shopping with us!");
        }
        $this->register = null;
    }

    /**
     * Scan all the products on the shopping list
     */
    function scanProducts()
    {
        if (is_null($this->register)) {
            //For storyline
            echo ($this->name . ' tries to scan products but (s)he is not at a register');
            return;
        } else {
            /**
             * While there are items on the shopping list:
             * Get an item from the shopping list (crossing it off)
             * then scan it via the scanner
             */
            while ($this->shoppingList->hasItems()) {
                $this->register->getScanner()->scanProduct($this->shoppingList->getNextItem());
            }
        }
    }

    /**
     * Look at the screen to see what is being displayed
     */
    function viewCartContentOnScreen()
    {
        $this->register->getScreen()->showShoppingCartContent();
    }

    /**
     * Make the payment based on payment method
     */
    function makePayment()
    {
        //Check if the customer is at the register
        if (is_null($this->register)) {
            //For storyline
            echo ($this->name . ' tries to check out but (s)he is not at a register');
            return;
        }

        /**
         * Make the payment
         * Based on the payment method use the pin device or the cash drawer
         */
        if ($this->paymentMethod == PAYMENT_METHOD_CARD) {
            $this->register->getPinDevice()->makePayment($this->balance);
        } else if ($this->paymentMethod == PAYMENT_METHOD_CASH) {
            $this->register->getCashDrawer()->makePayment($this->balance);
        }

        /**
         * Retrieve the ticket from the printer
         */
        $this->register->getPrinter()->showFinalTicket();
        if (!$this->register->paymentIsSuccesful()) {
            //For storyline
            echo ($this->name . ' tries to pay but failed...<br>');
        }
    }

    /**
     * For violent customers who like to destroy things
     * (and for the test case to force an always malfunctioning pin device)
     */
    function destroyPinDevice()
    {
        $this->register->setBrokenPinDevice();
    }
}
