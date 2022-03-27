<?php

/**
 * The register is the overarching object that implements the MVC model
 * A register keeps track of the shopping cart (model)
 * It has a cash drawer and pin device for payment and a scanner to add products to the shopping cart (controllers)
 * It has a screen to show the content of the shopping cart and a printer to print the final receipt (views)
 */
class Register
{
    private $cashDrawer;
    private $pinDevice;
    private $scanner;
    private $shoppingCart;
    private $printer;
    private $screen;

    function __construct()
    {
        /**
         * Construct the MVC
         */
        $this->shoppingCart = new ShoppingCart();

        $this->cashDrawer = new CashDrawer($this->shoppingCart);
        $this->pinDevice = new PinDevice($this->shoppingCart);
        $this->scanner = new Scanner($this->shoppingCart);
        $this->printer = new Printer($this->shoppingCart);
        $this->screen = new Screen($this->shoppingCart);
    }

    /**
     * Sub module interfaces to the cash drawer, pin device, scanner, screen and printer
     */
    function getCashDrawer()
    {
        return $this->cashDrawer;
    }
    function getPinDevice()
    {
        return $this->pinDevice;
    }
    function getScanner()
    {
        return $this->scanner;
    }
    function getScreen()
    {
        return $this->screen;
    }
    function getPrinter()
    {
        return $this->printer;
    }

    /**
     * For storyline: Check if the payment was succesful
     */
    function paymentIsSuccesful()
    {
        return $this->shoppingCart->isStatusSuccess();
    }

    /**
     * For test case: Break the pin device
     */
    function setBrokenPinDevice()
    {
        $this->pinDevice->overwriteReliability(0);
    }
}
