<?php
session_start();
include('connect.php');

if (empty($_GET['ic'])) {
    header('Location: error.php'); // check if data token exist
    exit;
}

$query = "select * from items where iCode = {$_GET['ic']} and Active != 'disabled'";
$result = mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));

if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
} else {
    header('Location: error.php?ec=12'); // check if item exist
    exit;
}
?>
<html>
    <head>
        <?php include('link.php'); ?>
        <title>EpicElectro | View</title>
    </head>
    <body>
        <?php include('header.php'); ?>

        <div>
        <form class="wrapper" method="post" action="viewProcess.php">
            <div class="container view">
                <section>
                    <?php
                    echo "<div class='img'><img src='images/{$_GET['ic']}.{$data['img_ext']}' alt='{$_GET['ic']}'></div>";
                    echo "<h3> {$data['iDesc']} </h3>";
                    if (empty($data['iComment'])) {
                        echo "<h4> No Description Found </h4>";
                    } else {
                        echo "<h4> {$data['iComment']} </h4>";
                    }
                    echo "<h5>by {$data['iBrand']}</h5>";
                    ?>
                </section>

                <?php
                $cartQty = 0; // get how many of this item in cart
                if (isset($_SESSION['CART'])) {
                    if (array_key_exists($_GET['ic'], $_SESSION['CART'])) {
                        $cartQty = $_SESSION['CART'][$_GET['ic']]['qty'];
                    }
                }
                ?>

                <aside>
                    <div class="cart">
                        <?php echo "<a href='cart.php#{$_GET['ic']}'>Cart</a>"; ?>
                        <span>
                            <?php
                            if (isset($_SESSION['CART'])) {
                                echo count($_SESSION['CART']);
                            } else {
                                echo 0;
                            }
                            ?>
                        </span>
                        <?php echo "<span> In Cart: $cartQty </span>"; ?>
                    </div>

                    <div class="amount">
                        <?php echo "<span> Price: ". number_format($data['iPrice']) ." OMR </span>"; ?>

                        <div class="control">
                            <?php
                            if ($data['iQty'] > 1 && !($cartQty >= $data['iQty']-1)) {$d = "";}
                            else {$d = "disabled";}
                            
                            echo "<input class='less' id=". 'less'.$_GET['ic'] ." type='button' value='&minus;' onclick='controller(\"less\", {$_GET['ic']})' disabled>";
                            echo "<span class='number' id=". 'number'.$_GET['ic'] ."> 1 </span>";
                            echo "<input class='more' id=". 'more'.$_GET['ic'] ." type='button' value='&plus;' onclick='controller(\"more\", {$_GET['ic']})' $d>";

                            echo "<input id=". 'stock'.$_GET['ic'] ." type='hidden' value='". ($data['iQty'] - $cartQty) ."'>"; // max value for javascript
                            ?>
                        </div>

                        <?php
                        if ($data['iQty'] > 0) {echo "<span> Available: {$data['iQty']} </span>";}
                            else {echo "<span> Not Available </span>";}

                            if ($data['iQty'] > 0 && $data['iQty'] > $cartQty) {$d = "";}
                            else {$d = "disabled";}

                        echo "<input id='submit' type='submit' value='Add' $d>";

                        echo "<input type='hidden' name='ic' value='{$_GET['ic']}'>";
                        echo "<input type='hidden' name='price' value='{$data['iPrice']}'>";
                        echo "<input id=". 'qty'.$_GET['ic'] ." type='hidden' name='qty' value='1'>";
                        ?>
                    </div>

                    <?php echo "<a class='back' href='index.php#{$_GET['ic']}'>Back</a>"; ?>
                </aside>
            </div>
        </form>
        </div>

        <?php include("footer.php"); ?>
    </body>
</html>