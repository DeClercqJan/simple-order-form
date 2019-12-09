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

$error_array = array();

if (isset($_POST["submit"])) {
    // was niet gemakkelijk om verschillende issets voor fields te combineren // 
    // opgelet: is set werkt niet goed, omdat het blijkbaar een empty string is var_dump($_POST["email"]);
    if (empty($_POST["email"]) || empty($_POST["street"]) || empty($_POST["streetnumber"])  || empty($_POST["city"]) || empty($_POST["zipcode"])) {
        array_push($error_array, "You need to fill out all the fields");
    }

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST["email"];
        $_SESSION["email"] = $email;
    } else {
        array_push($error_array, "You need to enter a valid e-mail adress");
    }
    if (is_numeric($_POST["streetnumber"])) {
        $streetnumber = $_POST["streetnumber"];
        $_SESSION["streetnumber"] = $streetnumber;
    } else {
        array_push($error_array, "You need to enter a number in the street number field");
    }
    if (is_numeric($_POST["zipcode"])) {
        $zipcode = $_POST["zipcode"];
        $_SESSION["zipcode"] = $zipcode;
    } else {
        array_push($error_array, "You need to enter a number in the zipcode number field");
    }

    $street = $_POST["street"];
    $_SESSION["street"] = $street;
    $city = $_POST["city"];
    $_SESSION["city"] = $city;
    $delivery_type =  $_POST["delivery-type"];
    $_SESSION["delivery-type"] = $delivery_type;
    // TO DO: ALLE SELECTED ITEMS TOEVOEGEN AAN ARRAY
    // dusver heb ik html al wat kunnen veradneren dat de value veranderd is, maar het lukt me nog niet om verschillende zaken te selecteren
    $items_selected = [];

}

$_SESSION["error-array-cookie"] = $error_array;

if (isset($_POST["submit"]) && empty($_SESSION["error-array-cookie"])) {
    // VRAAG: neem ik nu best cookies of variabele of maakt het niet uit?
    class order
    {
        public function __construct($email, $street, $streetnumber, $city, $zipcode, $delivery_type)
        {
            $this->email = $email;
            $this->street = $street;
            $this->streetnumber = $streetnumber;
            $this->city = $city;
            $this->zipcode = $zipcode;
            $this->delivery_type = $delivery_type;
        }
    }
    $new_order = new order($email, $street, $streetnumber, $city, $zipcode, $delivery_type);
    // var_dump($new_order);
    $message = "";
    $message = "The e-mailadres is $email. The adress is $street $streetnumber. $zipcode $city. The method of delivery is $delivery_type. The order is TO DO <br>";
    // echo $message;

    //DEZE BESTE DUSVER
    // mail("declercqjan@gmail.com", "object eens proberen doorsturen", $message);


    // TO DO nu mail maken die er mooi uitziet in e-mailclient. Sander heeft daar een mooiere manier voor, door een html tempalte te maken, die aan te roepen met file_get_contents en dan een aantal zaken te veradneren"
    // letterlijke code van https://emailmonks.com/blog/email-coding/step-step-guide-create-html-email rendert niet  in mijn gmail
    // hieronder ook eens wat escape characters gebruikt //
    /* $message =
 "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"https://www.w3.org/1999/xhtml\">
<head>
<title>Test Email Sample</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\" />
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0 \" />
<style>
<!--- CSS code (if any) --->
</style>
</head>
<body>
<table>
<thead>
<tr>
<th colspan=\"2\">Order overview</th>
</tr>
</thead>
<tbody>
<tr>
<td>e-mailadress</td>
<td>$email</td>
</tr>
<tr>
<td>street name</td>
<td>$street</td>
</tr>
<tr>
<td>numer</td>
<td>$streetnumber</td>
</tr>
<tr>
<td>city</td>
<td>$city</td>
</tr>
<tr>
<td>post code</td>
<td>$zipcode</td>
</tr>
<tr>
<td>e-mailadress</td>
<td>$delivery_type</td>
</tr>
<tr>
<td>ORDER</td>
<td>TO DO</td>
</tr>
</tbody>
</table>
</body>
</html>"; */
}

// deze verplaatst, want anders moest ik 2 keer drukken op knop alvorens ik de reeds ingevulde velden kon laten bevolken door cookies. ik vermoed dat het komt door de volgorde van uitvoeren
require 'form-view.php';
