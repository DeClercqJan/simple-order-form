<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
//we are going to use session variables so we need to enable sessions
session_start();
function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];
$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];
$totalValue = 0;
require 'form-view.php';

// edit: below all code written by me, Jan

// to do: check if set
// to do validate









if (isset($_POST["submit"])) {
    // was niet gemakkelijk om verschillende issets voor fields te combineren // 
    // opgelet: is set werkt niet goed, omdat het blijkbaar een empty string is var_dump($_POST["email"]);
    if (!empty($_POST["email"]) && !empty($_POST["street"])  && !empty($_POST["streetnumber"])  && !empty($_POST["city"])  && !empty($_POST["zipcode"])) {
        echo "is not empty";
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
            echo "is valid";
        } else {
            echo "<script type='text/javascript'>alert('You need to enter a valid e-mailadress');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('You need to fill out the form');</script>";
    }
}
