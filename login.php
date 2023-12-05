<?php session_start(); ?>
<html>
    <head>
        <?php include('link.php') ?>
        <title>EpicElectro | Login</title>
    </head>
    <body>
        <?php
        include('header.php'); 
        include("connect.php");

        if (isset($_SESSION['CID'])) {
            header('Location: error.php?ec=2'); //user is already logged in
            exit;
        }
        ?>

        <form class="form" action="loginProcess.php" method="post">
            <div class="main">
                <fieldset>
                    <legend>Login</legend>

                    <label>
                        Email:<br>
                        <input type="text" name="mail" required>
                    </label>

                    <label>
                        Password:<br>
                        <input type="password" name="pass" required>
                    </label>
                </fieldset>

                <h4>Forgot your password? <a href="loginReset.php">Reset</a></h4>
                <h4 style="margin-top: .5rem;">Don't have an account? <a href="register.php">Register</a></h4>

                <div class="buttons">
                    <input class="btn left" type="submit" value="Login">
                    <input class="btn right" type="reset" value="Clear">
                </div>
            </div>
        </form>
        
        <?php include('footer.php'); ?>
        <?php if (isset($_GET["s"])) {echo "<script>notify('Account Registered Successfully');</script>";} // when creating an account ?>
        <?php if (isset($_GET["r"])) {echo "<script>notify('Password Reset Request Has Been Sent', '#b45100');</script>";} // when reseting a password ?>
        <?php if (isset($_GET["d"])) {echo "<script>notify('Account Has Been Disabled', 'darkred');</script>";} // when disabling an account ?>
    </body>
</html>