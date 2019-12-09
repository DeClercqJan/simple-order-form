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
//edit: deze file onder andere code gezet
//require 'form-view.php';
// edit: below all code written by me, Jan

// TO DO: After sending the form, when you have errors show them in a nice error box above the form, you can use the bootstrap alerts for inspiration. https://getbootstrap.com/docs/4.0/components/alerts/
// TO DO: If the form is valid (for now) just show the user a message above the form that his order has been sent

if (isset($_POST["submit"])) {
    // was niet gemakkelijk om verschillende issets voor fields te combineren // 
    // opgelet: is set werkt niet goed, omdat het blijkbaar een empty string is var_dump($_POST["email"]);
    if (!empty($_POST["email"]) && !empty($_POST["street"])  && !empty($_POST["streetnumber"])  && !empty($_POST["city"])  && !empty($_POST["zipcode"])) {
        // echo "is not empty";
        if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
            // echo "is valid";
            $_SESSION["email"] = $email;
            echo $_SESSION["email"];
            var_dump($_SESSION["email"]);
        } else {
            echo "<script type='text/javascript'>alert('You need to enter a valid e-mailadress');</script>";
        }
        if (!is_numeric($_POST["streetnumber"]) || !is_numeric($_POST["zipcode"])) {
            echo  "<script type='text/javascript'>alert('You need to enter a number in both the streetnumber and zipcode fields');</script>";
        } else {
            // echo "succes!";
            $streetnumber = $_POST["streetnumber"];
            $zipcode = $_POST["zipcode"];
            $_SESSION["streetnumber"] = $streetnumber;
            $_SESSION["zipcode"] = $zipcode;
        }
    } else {
        echo "<script type='text/javascript'>alert('You need to fill out the form');</script>";
    }
}

// deze verplaatst, want anders moest ik 2 keer drukken op knop alvorens ik de reeds ingevulde velden kon laten bevolken door cookies. ik vermoed dat het komt door de volgorde van uitvoeren
require 'form-view.php';
