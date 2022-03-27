<?php

/**
 * Printer is a View and has access to the shoppingCart Model
 * The only thing this printer does is printing the ticket
 */
class Printer
{
    private $shoppingCart;

    function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * Show the final ticket on the screen
     * Get the data from the shopping cart model
     * If the payment was succesful then show the # of products, total price and the change based on the budget
     * If the payment was not succesful print out the error
     */
    function showFinalTicket()
    {
        echo ('<pre>ticket content -></pre>');
        echo ('<div class="ticket"><b>FooShop</b><br>');
        if ($this->shoppingCart->isStatusSuccess()) {
            echo ('Number of products: ' . $this->shoppingCart->getTotalNumberOfProducts() . '<br>');
            echo ('Grand total: €' . number_format((float)$this->shoppingCart->getGrandTotal(), 2, '.', '') . '<br>');
            echo ('Change: € ' . number_format((float)$this->shoppingCart->getChange(), 2, '.', '') . '<br>');
        } else if ($this->shoppingCart->isStatusFailed()) {
            echo ('### ERROR ###<br>');
            echo ($this->shoppingCart->getStatusMessage() . '<br>');
        }
        echo ('</div>');
    }
}
