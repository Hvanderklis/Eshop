<?php include ("./include/header.php");?>
<?php include ("./config/connect.php");?>

<div class="container">
    <div class="row">

        <?php
            $query = "SELECT * FROM cart_producten";
            $query_result = $conn->query( $query );
            $results_array = $query_result->fetchAll(PDO::FETCH_ASSOC);

            if ( $database_config['debug'] ) {
                echo "<pre>";
                print_r( $results_array );
                echo "</pre>";
            }

            foreach ( $results_array as $product ) {
        ?>
                <div class="col-md-4 col-xs-12 productlisting">
                    <h2><?php echo $product['name']; ?></h2>
                    <p>&euro; <?php echo $product['price']; ?></p>
                    <a href="./cart.php?pid=<?php echo $product['id']; ?>">Add to cart</a>
                </div>
        <?php
            }
        ?>
    </div>
</div>


<?php include ("./include/footer.php");?>