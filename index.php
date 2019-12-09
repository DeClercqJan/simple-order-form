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
$products_food = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];
$products_drinks = [
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

$error_array = array();

if (isset($_POST["submit"])) {
    // was niet gemakkelijk om verschillende issets voor fields te combineren // 
    // opgelet: is set werkt niet goed, omdat het blijkbaar een empty string is var_dump($_POST["email"]);
    if (empty($_POST["email"]) || empty($_POST["street"]) || empty($_POST["streetnumber"])  || empty($_POST["city"]) || empty($_POST["zipcode"])) {
        // echo "<script type='text/javascript'>alert('You need to fill out all the fields');</script>";
        array_push($error_array, "You need to fill out all the fields");
    }


    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;
    } else {
        // echo "<script type='text/javascript'>alert('You need to enter a valid e-mailadress');</script>";
        array_push($error_array, "You need to enter a valid e-mail adress");
    }
    if (is_numeric($_POST["streetnumber"])) {
        $streetnumber = $_POST["streetnumber"];
        $_SESSION["streetnumber"] = $streetnumber;
    } else {
        // echo  "<script type='text/javascript'>alert('You need to enter a number in both the streetnumber field');</script>";
        array_push($error_array, "You need to enter a number in the street number field");
    }
    if (is_numeric($_POST["zipcode"])) {
        $zipcode = $_POST["zipcode"];
        $_SESSION["zipcode"] = $zipcode;
    } else {
        echo  "<script type='text/javascript'>alert('You need to enter a number in both the zipcode field');</script>";
        array_push($error_array, "You need to enter a number in the zipcode number field");
    }

    $street = $_POST["street"];
    $_SESSION["street"] = $street;
    $city = $_POST["city"];
    $_SESSION["city"] = $city;
}

$_SESSION["error-array-cookie"] = $error_array;

if (isset($_POST["submit"]) && empty($_SESSION["error-array-cookie"])) {
    mail("declercqjan@gmail.com", "test", "testen of knop werkt");
}
    
    // deze verplaatst, want anders moest ik 2 keer drukken op knop alvorens ik de reeds ingevulde velden kon laten bevolken door cookies. ik vermoed dat het komt door de volgorde van uitvoeren
require 'form-view.php';
