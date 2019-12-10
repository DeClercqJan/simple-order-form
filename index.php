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
$order_total = 0;
//edit: deze file onder andere code gezet
//require 'form-view.php';
// edit: below all code written by me, Jan

$error_array = array();

if (isset($_GET["submit"])) {
    // was niet gemakkelijk om verschillende issets voor fields te combineren // 
    // opgelet: is set werkt niet goed, omdat het blijkbaar een empty string is var_dump($_GET["email"]);
    if (empty($_GET["email"]) || empty($_GET["street"]) || empty($_GET["streetnumber"])  || empty($_GET["city"]) || empty($_GET["zipcode"])) {
        array_push($error_array, "You need to fill out all the fields");
    }

    if (filter_var($_GET["email"], FILTER_VALIDATE_EMAIL)) {
        $email = $_GET["email"];
        $_SESSION["email"] = $email;
    } else {
        array_push($error_array, "You need to enter a valid e-mail adress");
    }
    if (is_numeric($_GET["streetnumber"])) {
        $streetnumber = $_GET["streetnumber"];
        $_SESSION["streetnumber"] = $streetnumber;
    } else {
        array_push($error_array, "You need to enter a number in the street number field");
    }
    if (is_numeric($_GET["zipcode"])) {
        $zipcode = $_GET["zipcode"];
        $_SESSION["zipcode"] = $zipcode;
    } else {
        array_push($error_array, "You need to enter a number in the zipcode number field");
    }

    $street = $_GET["street"];
    $_SESSION["street"] = $street;
    $city = $_GET["city"];
    $_SESSION["city"] = $city;
    $delivery_type =  $_GET["delivery-type"];
    $_SESSION["delivery-type"] = $delivery_type;
    // TO DO: ALLE SELECTED ITEMS TOEVOEGEN AAN ARRAY
    // dusver heb ik html al wat kunnen veradneren dat de value veranderd is, maar het lukt me nog niet om verschillende zaken te selecteren
    // opgelet: je moet het dus in je html products[] noemen om dan in je php aan te roepen met products https://www.formget.com/php-checkbox/
    // echo $_GET["products"];
    // print_r($_GET["products"]);
    // echo serialize($_GET["products"]);
    $items_selected = $_GET["products"];
    // moet ik deze nu serializen of niet? ik heb het op een andere plek gedaan voor de errors zonder te serializen; dus meteen array in cookie gestoken
    // echter: moet ik dit wil in cookie steken? ik denk dat het het beste is voor de klant om dit niet te doen en enkel als alles ok is, volledig door te sturen. Ik zou vooral ontevreden klanten willen vermijden en hen per ongeluk iets laten kopen dat ze niet willen is niet ok.
    /* $_SESSION["items-selected"] = serialize($items_selected);
    if (isset($_SESSION["items-selected"])) {
        print_r($_SESSION["items-selected"]);
        unserialize()
    }
    */
    // ik moet wél product en prijs scheiden lijkt me
    // print_r($items_selected);
    // moet het eigenlijk omvormen hé; dus meteen zo en niet eerst er een hele array van maken; wat allicht ook kan, maar minder direct naar de uikomst gaat
    $items_selected_new = [];
    foreach ($items_selected as $key => $value) {
        // print_r($key);
        $selected_item_separated = explode(" ", $value);
        // print_r($selected_item_separated);
        $key = $selected_item_separated[0];
        // print_r($key);
        $value = $selected_item_separated[1];
        // print_r($value);
        // print_r($test);
        // $selected_item_separated = explode(" ", $selected_item);
        // print_r($selected_item_separated);
        $items_selected_new[$key] = $value;
    }
    // print_r($items_selected_new);
}

$_SESSION["error-array-cookie"] = $error_array;

if (isset($_GET["submit"]) && empty($_SESSION["error-array-cookie"])) {
    // VRAAG: neem ik nu best cookies of variabele of maakt het niet uit?
    class order
    {
        public function __construct($email, $street, $streetnumber, $city, $zipcode, $delivery_type, $items_selected_new, $total_order)
        {
            $this->email = $email;
            $this->street = $street;
            $this->streetnumber = $streetnumber;
            $this->city = $city;
            $this->zipcode = $zipcode;
            $this->delivery_type = $delivery_type;
            // $this->$items_selected_new = $items_selected_new;
            // $this->$test = "test";
            // GEEN IDEE WAAROM DIT ZO MOET, DOOR PRUTSEN GEVODNEN HOE IK DE PROPERTY VAN DE ARRAY MOET ZETTEN, MAAR NOG ALTIJD EEN NOTICE OMDAT HET NIET IN MIOJN DECLARATIE VAN NEW ORDER ZIT HIERONDER
            // idee: het toevoegen als een empty ding via de parameters die naar de constructor wordt gestuurd
            // heb dan ook nog een foutmelding gekregen van dat het niet numeric was en er dan een float op toegepast. waarom dait zo werkt, is me onbekend. Ik dacht een string doorgestuurd te hebben met een tekst, maja
            $this->$total_order = (float) $total_order;
            foreach ($items_selected_new as $key => $value) {
                // moest het omvormen, want anders kwam hij gelijk soms op  6 terwijl het resultaat 5 moest zijn
                $this->$total_order += (float) $value;
                // var_dump($key);
                // var_dump($value);
            }
            // AH, DENK DAT IK HET HEB: linkerkant is de naam die het binnen het object krijgt en die kan je aanpassen
            $this->ordered_items = $items_selected_new;
            // $this->$total_order = $value_float;
            // $this->$total_order = $total_order * 2;
        }
    }
    // $total_order = 0;
    $total_order = "total order";
    $new_order = new order($email, $street, $streetnumber, $city, $zipcode, $delivery_type, $items_selected_new, $total_order);
    // var_dump($new_order);
    // na bevolking van de variabele door constructorfunctie ook waarde doorgeven aan variabele die onderaan de pagina staat
    $order_total = $new_order->$total_order;

    // nu van al die verschillende gekochte zaken in het object een string maken om mee te geven met de message (ook een string)
    // OPGELET: GEEN $ BIJ ODNERSTAANDE PROPERTY
    //print_r($new_order->delivery_type);
    $ordered_items_string = "";
    foreach ($new_order->ordered_items as $item => $price) {
        // echo $item;
        // echo $price;
        $ordered_items_string = $ordered_items_string . "A $item voor $price euro, ";
    }
    // var_dump($ordered_items_string);

    $message = "";
    // opgelet: hieronder spreek ik eigenlijk niet mijn object aan. Hoewel een interessante oefening, heb ik het nu zo gedaan.
    $message = "The e-mailadres is $email. The adress is $street $streetnumber. $zipcode $city. The method of delivery is $delivery_type. You have ordered $ordered_items_string. The amount to be paid is $order_total";
    // echo $message;

    //DEZE BESTE DUSVER
    // mail("declercqjan@gmail.com", "Succesful order @ the Personal Ham Processors", $message);


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

// deze ook verplaatst, want ik sprak al eerder mijn header aan met, ik denk $_SERVER (zie bestand form-view)
if (!isset($_COOKIE["previous-orders-value"])) {
    if (isset($_GET["submit"]) && empty($_SESSION["error-array-cookie"])) {
        $totalValue_result = $order_total;
        // echo $order_total;
        // enigste manier waarop ik cookie kon laten veranderen
        // moest cookie ook string meegeven
        setcookie("previous-orders-value", strval($order_total));
    } else {
        $totalValue_result = 0;
    }
} else {
    if (isset($_GET["submit"]) && empty($_SESSION["error-array-cookie"])) {
        $previous_orders_value = $_COOKIE["previous-orders-value"];
        echo $previous_orders_value;
        $totalValue = $previous_orders_value + $order_total;
        setcookie("previous-orders-value", strval($totalValue));
        // $totalValue_result = "previeous orders value + nieuwe order indien succesvol hier, zijnde $totalValue";
        $totalValue_result = $totalValue;
    } else {
        $previous_orders_value = $_COOKIE["previous-orders-value"];
        // $totalValue_result = "previeous orders value, zijnde $previous_orders_value";
        $totalValue_result = $previous_orders_value;
    }
}

// deze verplaatst, want anders moest ik 2 keer drukken op knop alvorens ik de reeds ingevulde velden kon laten bevolken door cookies. ik vermoed dat het komt door de volgorde van uitvoeren
require 'form-view.php';
