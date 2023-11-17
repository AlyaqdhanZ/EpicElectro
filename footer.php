<footer id="down">
    &copy; Copyright of EpicElectro is Reserved to 
    <abbr title="University of Technology and Applied Sciences">UTAS</abbr>
    <?php
    if (isset($_SESSION['NAME'])) {

        $fullName = explode(" ", $_SESSION['NAME']);
        if (count($fullName) > 1) {
            $Fname = $fullName[0];
            $Lname = array_pop($fullName);
            $name = $Fname." ".$Lname;
        } else {
            $name = $fullName[0];
        }

        if ($_SESSION['TYPE'] == 'A') {
            $type = "Admin";
        } else {
            $type = "Normal";
        }

        echo " ︱ $name ($type) <a href='logout.php'> Logout </a>";
    }
    ?>
</footer>

<script src="main.js"></script>