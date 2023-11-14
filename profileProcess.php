<?php
    include("connect.php");
    include('library.php');

    if (!isset($_POST['name'])) {
        header('Location: error.php?ec=-1'); // entered page without button
        exit;
    }
    
    $errors = [];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mail = mysqli_real_escape_string($conn, $_POST['email']);
    $pass0 = mysqli_real_escape_string($conn, $_POST['passwordOld']);
    $pass = mysqli_real_escape_string($conn, $_POST['passwordNew']);
    $pass2 = mysqli_real_escape_string($conn, $_POST['passwordConfirm']);
    $number = mysqli_real_escape_string($conn, $_POST['pnumber']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    if (!preg_match("/^[a-zA-Z\-\s]+$/", $name)) {
        $errors[] = "Please enter a valid name";
    }

    if ($pass != $pass2) {
        $errors[] = "Please make sure you typed the same new password";
    }
    
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email";
    }

    if ($number < 1 || !preg_match("/^[9|7][0-9]{7}$/", $number)) {
        $errors[] = "Please enter a valid phone number";
    }

    if (count($errors) == 0) {
        $query = "select * from customers where password = password('$pass0') and cId = {$_POST['cid']}";
        $result = mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));
        if (mysqli_num_rows($result) == 0) {
            header('Location: error.php?ec=5'); // old password is incorrect
            exit;
        }

        $query = "select * from customers where cId = '{$_POST['cid']}'";
        $result = mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));
        $customer = mysqli_fetch_assoc($result);
        if ($customer['email'] != $mail) { // check if user change email
            $query = "select * from customers where email = '$mail'";
            $result = mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));
            if (mysqli_num_rows($result) == 1) {
                header('Location: error.php?ec=4'); // account already exists
                exit;
            }
        }

        if (empty($pass) && empty($pass2)) {
            $pass = $pass0;
        }

        $query = "update customers set";
        $query .= " cName = '$name',";
        $query .= " password = password('$pass'),";
        $query .= " email = '$mail',";
        $query .= " cAddress = '$address',";
        $query .= " phoneNumber = $number";
        $query .= " where cId = '{$_POST['cid']}'";
        mysqli_query($conn, $query) or die("Error in query: <mark>$query</mark> <p>". mysqli_error($conn));

        header("location: index.php");
    } else {
        DisplayErrors();
    }
?>