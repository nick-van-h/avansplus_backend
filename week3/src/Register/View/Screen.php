<?php


/**
 * Screen is a View and has access to the shoppingCart Model
 * The only thing this screen does is showing the shopping cart content
 */
class Screen
{
    private $shoppingCart;

    function __construct(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }

    /**
     * List all the items in the shopping cart
     * Show the # of products, product name, price per piece and total price per product in a table
     * Show the grand total below the table
     */
    function showShoppingCartContent()
    {
        $products = $this->shoppingCart->getProducts();
        echo ('<pre>screen content -></pre>');
        echo ('<div class="screen">');
        echo ('<table><tr><th>Qty</th><th>Product</th><th>Price each</th><th>Subtotal</th></tr>');
        foreach ($products as $product) {

            echo ('<tr>');
            echo ('<td> ' . $product->getQty() . '</td>');
            echo ('<td>' . $product->getName() . '</td>');
            echo ('<td>€' . number_format((float)$product->getPrice(), 2, '.', '') . '</td>');
            echo ('<td>€' . number_format((float)($product->getQty() * $product->getPrice()), 2, '.', '') . '</td>');
            echo ('</tr>');
        }
        echo ("</table>");
        echo ("<i>Grand total: €" . number_format((float)$this->shoppingCart->getGrandTotal(), 2, '.', '') . '</i><br></div>');
    }
}
