<?php include './config/connect.php'; ?>
<?php

///
///Customer Making
///

try {
    $stmt = $conn->prepare("INSERT INTO cart_producten (name, price) VALUES (?, ?)");
    $stmt->bindParam(1, $name);
    $stmt->bindParam(2, $price);

    /// Insert one row
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stmt->execute();
    $lastId = $conn->lastInsertId();
}
catch ( PDOException $ex ) {
    if( $database_config['debug'] ) {
        $error = $ex->getMessage();
        echo $error;
    }
}

?>