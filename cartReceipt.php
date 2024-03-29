<?php
session_start(); 
if (empty($_GET['oi'])) {
    header('Location: error.php'); // trying to access process from address bar
    exit;
}
?>
<html>
    <head>
        <?php include('link.php') ?>
        <title>EpicElectro | Receipt</title>
    </head>
    <body>
        <?php
        include('header.php');
        include("connect.php");
        ?>

        <div>
        <div class="wrapper">
            <div class="container receipt">
                <fieldset>
                    <legend>Order Placed Successfuly</legend>

                    <h3>Thank you for your purchase from EpicElectro, a receipt will be 
                        sent to the email registred via this account shortly.</h3>

                    <div id="main">
                        <h1>⬇ Meanwhile ⬇</h1>

                        <h2>Check our other products:</h2>
                        <a href="index.php">Home</a>
                        
                        <h2>Or see your orders history:</h2>
                        <a href="order.php">Orders</a>
                        
                        <h5>Order No: <?php echo $_GET['oi']; ?></h5>
                    </div>
                </fieldset>
            </div>
        </div>
        </div>
        
        <?php include('footer.php'); ?>
    </body>
</html>