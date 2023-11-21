<?php
session_start();
if (!isset($_SESSION['CART'])) {
    header('Location: error.php?ec=1'); // login required
    exit;
}

if (!isset($_POST['ic'])) {
    header('Location: error.php?ec=-1'); // entered page without button
    exit;
}

$in_cart = false; // check if item already exist
foreach ($_SESSION['CART'] as $key => $item) {
    if (in_array($_POST['ic'], $item)) {
        $_SESSION['CART'][$key]['qty'] += $_POST['qty'];
        $in_cart = true;
    }
}

if ($in_cart == false) {
    array_push($_SESSION['CART'], ["ic" => $_POST['ic'], "price" => $_POST['price'], "qty" => $_POST['qty']]);
}

header("Location: view.php?ic={$_POST['ic']}");
?>