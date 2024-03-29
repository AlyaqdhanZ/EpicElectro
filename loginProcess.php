<?php
include('connect.php');

if (!isset($_POST['mail'])) {
    header('Location: error.php'); // trying to access process from address bar
    exit;
}

$mail = mysqli_real_escape_string($conn, $_POST['mail']);
$pass = mysqli_real_escape_string($conn, $_POST['pass']);

$accounts = mysqli_query($conn, "select * from customers where email = '$mail'");
$account = mysqli_fetch_assoc($accounts);

if (mysqli_num_rows($accounts) == 0) {
    header('Location: error.php?ec=9'); // account doesnt exist
    exit;
}

if ($account['Active'] != 'active') {
    header('Location: error.php?ec=10'); // account is disabled
    exit;
}

$query = "select * from customers where email = '$mail' and password = password('$pass')";
$result = mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));

if (mysqli_num_rows($result) == 1) {
    $customer = mysqli_fetch_assoc($result);
    session_start();
    
    $_SESSION['MAIL'] = $customer['email'];
    $_SESSION['NAME'] = $customer['cName'];
    $_SESSION['TYPE'] = $customer['cType'];
    $_SESSION['CID'] = $customer['cId'];
    $_SESSION['CART'] = array();

    $dateTime = date('Y-m-d H:i:s');
    $query = "update customers set lastLogin = '$dateTime' where cId = '{$customer['cId']}'";
    mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));

    header('Location: index.php?s');
} else {
    header('Location: error.php?ec=0'); //userid or passsword is wrong
    exit;
}
?>