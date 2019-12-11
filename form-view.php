<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <title>Order food & drinks</title>
</head>

<body>
    <div class="container">
        <h1>Order food in restaurant "the Personal Ham Processors"</h1>
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link active" href="?food=1 ">Order food</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?food=0">Order drinks</a>
                </li>
            </ul>
        </nav>
        <!-- dit toegevoegd -->
        <?php
        if (!empty($_SESSION["error-array-cookie"])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo "<ul>";
            foreach ($_SESSION["error-array-cookie"] as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
            echo "</div>";
        }
        if (isset($_GET["submit"]) && empty($_SESSION["error-array-cookie"])) {
            echo '<div class="alert alert-primary" role="alert">';
            echo "your order was succesfully sent! Feeding process initiated ";
            if ($delivery_type == "normal") {
                echo "You'll receive nutrients within 2 hours";
            }
            if ($delivery_type == "express") {
                echo "You'll receive nutrients in 45 minutes";
            }
            echo "</div>";
        }
        ?>
        <form method="get" action="index.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">E-mail:</label>
                    <input type="text" id="email" name="email" class="form-control" <?php
                                                                                    if (isset($_SESSION["email"])) {
                                                                                        echo "value=" . $_SESSION["email"];
                                                                                    }
                                                                                    ?> />
                </div>
                <div></div>
            </div>

            <fieldset>
                <legend>Address</legend>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="street">Street:</label>
                        <input type="text" name="street" id="street" class="form-control" <?php
                                                                                            if (isset($_SESSION["street"])) {
                                                                                                echo "value=" . $_SESSION["street"];
                                                                                            }
                                                                                            ?>>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="streetnumber">Street number:</label>
                        <input type="text" id="streetnumber" name="streetnumber" class="form-control" <?php
                                                                                                        if (isset($_SESSION["streetnumber"])) {
                                                                                                            echo "value=" . $_SESSION["streetnumber"];
                                                                                                        }
                                                                                                        ?> />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">City:</label>
                        <input type="text" id="city" name="city" class="form-control" <?php
                                                                                        if (isset($_SESSION["city"])) {
                                                                                            echo "value=" . $_SESSION["city"];
                                                                                        }
                                                                                        ?>>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="zipcode">Zipcode</label>
                        <input type="text" id="zipcode" name="zipcode" class="form-control" <?php
                                                                                            if (isset($_SESSION["zipcode"])) {
                                                                                                echo "value=" . $_SESSION["zipcode"];
                                                                                            }
                                                                                            ?> />
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend>Products</legend>
                <?php
                //echo $_SERVER["SERVER_NAME"];
                $url = $_SERVER["REQUEST_URI"];
                // echo $url;
                $type_selector_stringnumber = 0;
                if (strpos($url, "?")) {
                    $url_separated = explode("?", $url);
                    // print_r( $url_separated);
                    $type_selector_string = $url_separated[1];
                    // echo $type_selector_string;
                    $type_selector_stringnumber = substr($type_selector_string, -1);
                    // echo $type_selector_stringnumber;
                }
                if ($type_selector_stringnumber == 1) {
                    // ook moeten aanpassen zodat value gepakt wordt
                    foreach ($products_food as $i => $product) : ?>
                        <label>
                            <input type="number" value="<?php echo $product['name'] . " " . $product['price']; ?>" min="0" name="products[<?php echo $product['name'];
                            ?>]"/> <?php echo $product['name'] ?> -
                            &euro; <?php echo number_format($product['price'], 2) ?></label><br />
                    <?php endforeach;
                    } else {
                        foreach ($products_drinks as $i => $product) : ?>
                        <label>
                            <input type="number" value="<?php echo $product['name'] . " " . $product['price']; ?>" min="0" name="products[<?php echo $product['name'];
                            ?>]"/> <?php echo $product['name'] ?> -
                            &euro; <?php echo number_format($product['price'], 2) ?></label><br />
                <?php endforeach;
                } ?>
            </fieldset>
            <fieldset>
                <legend>Products</legend>
                <label for="normal">normal(2 hours)</label>
                <input type="radio" name="delivery-type" value="normal" id="delivery-type" checked></br>
                <label for="express">express (45 minutes)</label>
                <input type="radio" name="delivery-type" value="express" id="delivery-type"></br>
            </fieldset>
            <button type="submit" class="btn btn-primary" name="submit">Order!</button>
        </form>

        <footer>You already ordered <strong>&euro; <?php echo $totalValue_result ?></strong> in food and drinks.</footer>
    </div>

    <style>
        footer {
            text-align: center;
        }
    </style>
</body>

</html>