<?php
include('library.php');
include('connect.php');

if (!isset($_POST['name'])) {
    header('Location: error.php'); // trying to access process from address bar
    exit;
}

$errors = [];

$name = mysqli_real_escape_string($conn, $_POST['name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);

if (preg_match("/^[0-9]+$/", $name)) {
    $errors[] = "Please enter a valid name";
}

if ($phone < 1 || !preg_match("/^[0-9]{8}$/", $phone)) {
    $errors[] = "Please enter a valid phone number";
}


if (count($errors) > 0) {
    DisplayErrors();
    exit;
}


$query = "insert into delivery (company_name, dPhone)";
$query .= " values ('$name', '$phone')";
mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));

header("Location: panelDelivery.php?s");
?>