<?php include './config/connect.php'; ?>
<?php

///
///Customer Making
///

try {
    $stmt = $conn->prepare("INSERT INTO cart_leverancier (Leveranciersnummer, Bedrijfsnaam, Adres, Postcode, Plaats, Telefoonnummer, Email) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $Leveranciersnummer);
    $stmt->bindParam(2, $Bedrijfsnaam);
    $stmt->bindParam(3, $Adres);
    $stmt->bindParam(4, $Postcode);
    $stmt->bindParam(5, $Plaats);
    $stmt->bindParam(6, $Telefoonnummer);
    $stmt->bindParam(7, $Email);
    /// Insert one row
    $Leveranciersnummer = $_POST['Leveranciersnummer'];
    $Bedrijfsnaam = $_POST['Bedrijfsnaam'];
    $Adres = $_POST['Adres'];
    $Postcode = $_POST['Postcode'];
    $Plaats = $_POST['Plaats'];
    $Telefoonnummer = $_POST['Telefoonnummer'];
    $Email = $_POST['Email'];
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