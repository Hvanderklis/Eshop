<?php include './include/header.php'; ?>
<?php include './config/connect.php'; ?>

<?php

///
///Customer Making
///

try {
    $stmt = $conn->prepare("INSERT INTO cart_klant (name, email) VALUES (?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $email);

    /// Insert one row
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt->execute();
    $lastId = $conn->lastInsertId();
}
catch ( PDOException $ex ) {
    if( $database_config['debug'] ) {
        $error = $ex->getMessage();
        echo $error;
    }
}

///
/// Calculate total price
///

session_start();
$total_order = 0;
if ( isset( $_SESSION['cart_content'] ) ) {
    $cart_array = explode(',', $_SESSION['cart_content']);

    foreach ($cart_array as $item) {
        $query = "SELECT * FROM cart_producten WHERE id='" . $item . "'";
        ///try to execute the SQL query
        $query_result = $conn->query($query);
        /// Return the result
        $product = $query_result->fetch(PDO::FETCH_ASSOC);
        $total_order += $product['price'];
    }
}

///
/// Make a new order
///

try {
    $stmt = $conn->prepare("INSERT INTO cart_bestellingen (total_price, klant_id) VALUES (?, ?)");
    $stmt->bindParam(1, $total_price);
    $stmt->bindParam(2, $klant_id);

    // Insert one row
    $total_price = $total_order;
    $klant_id = $lastId;
    $stmt->execute();
    $lastOrderId = $conn->lastInsertId();
}
catch ( PDOException $ex ) {
    if ( $database_config['debug'] ) {
        $error = $ex->getMessage();
        echo $error;
    }
}

///
/// Make a new order line
///

if ( isset( $_SESSION['cart_content'] ) ) {
    $cart_array = explode(',', $_SESSION['cart_content'] );

    foreach ($cart_array as $item) {
        $query = "SELECT * FROM cart_producten WHERE id='" . $item . "'";
        /// Try to execute the SQL query
        $query_result = $conn->query($query);
        $product = $query_result->fetch(PDO::FETCH_ASSOC);
        // Return the result
        try {
            $stmt = $conn->prepare("INSERT INTO cart_bestelling line (product_id, bestelling_id, aantal) VALUES (?, ?)");
            $stmt->bindParam(1, $product_id);
            $stmt->bindParam(2, $bestelling_id);
            $stmt->bindParam(3, $aantal);

            $product_id = $item;
            $bestelling_id = $lastOrderId;
            $aantal = 1;

            $stmt->execute();
        }
        catch ( PDOException $ex ) {
            if ( $database_config['debug'] ) {
                $error = $ex->getMessage();
                echo $error;

            }
        }
    }
}
?>
<div class="container">
    <div class="row">
        <p><br><br>Bedankt voor je bestelling. <br /> je zal binnen enkele ogenblikken een bevestiging ontvangen op het ingevoerde email adres: <?php echo $_POST['email'];?></p>
        <p>Je ordernummer: <?php echo $lastOrderId; ?></p>
        <?php
            if(ISSET($_POST["knopje"])){
                $to      =  $_POST['email'];
                $subject = 'Bevestiging bestelling';
                $message = "Bedankt voor je bestelling! We zullen de bestelde artikelen zo snel mogelijk naar je opsturen" . "\r\n" . "Uw ordernummer is: $lastOrderId";
                mail($to, $subject, $message);
            }

             session_destroy();
        ?>
    </div>
</div>