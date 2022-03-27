<?php

//For debugging
ini_set("display_errors", 1);

//Default include file
include('../src/includes.php');

//Include some mark-up
echo ('<style>');
echo (file_get_contents('style.css', true));
echo ('</style>');

/**
 * Generic set-up
 */
$catalog = new Catalog();
$shoppingList = new ShoppingList();

/**
 * Set-up for first customer
 * Happy flow with pin, 10 products
 */
for ($i = 0; $i < 10; $i++) {
    $shoppingList->addProduct($catalog->getRandomProduct());
}
$alice = new Customer('Alice', 100, $shoppingList, PAYMENT_METHOD_CARD);
$alice->goToRegister();
$alice->scanProducts();
$alice->viewCartContentOnScreen();
$alice->makePayment();
$alice->leaveRegister();


/**
 * Set-up for second customer
 * Happy flow with cash, 20 products
 */
$shoppingList->clear();
for ($i = 0; $i < 20; $i++) {
    $shoppingList->addProduct($catalog->getRandomProduct());
}
$bob = new Customer('Bob', 250, $shoppingList, PAYMENT_METHOD_CASH);
$bob->goToRegister();
$bob->scanProducts();
$bob->viewCartContentOnScreen();
$bob->makePayment();
$bob->leaveRegister();


/**
 * Set-up for third customer
 * Always failing pin device (overwritten for test case)
 */
$shoppingList->clear();
for ($i = 0; $i < 13; $i++) {
    $shoppingList->addProduct($catalog->getRandomProduct());
}
$chad = new Customer('Chad', 100, $shoppingList, PAYMENT_METHOD_CARD);
$chad->goToRegister();
$chad->scanProducts();
$chad->viewCartContentOnScreen();
$chad->destroyPinDevice();
$chad->makePayment();
$chad->leaveRegister();


/**
 * Set-up for fourth customer
 * 100 products and budget of 10, resulting in insufficient funds
 */
$shoppingList->clear();
for ($i = 0; $i < 100; $i++) {
    $shoppingList->addProduct($catalog->getRandomProduct());
}
$dave = new Customer('Dave', 10, $shoppingList, PAYMENT_METHOD_CASH);
$dave->goToRegister();
$dave->scanProducts();
$dave->viewCartContentOnScreen();
$dave->makePayment();
$dave->leaveRegister();
