<?php

/**
 * Default includes for all used files
 */

include('config.php');

include('Register/Register.php');

include('Register/Controller/PaymentDevice.php');
include('Register/Controller/CashDrawer.php');
include('Register/Controller/PinDevice.php');
include('Register/Controller/Scanner.php');

include('Register/Model/ShoppingCart.php');

include('Register/View/Printer.php');
include('Register/View/Screen.php');

include('Customer/ShoppingList.php');
include('Customer/Customer.php');

include('ProductCatalog/Catalog.php');
include('ProductCatalog/Product.php');
