<?php
use PHPMailer\PHPMailer\PHPMailer;
require __DIR__ .'/PHPMailer/src/PHPMailer.php';
require __DIR__ .'/PHPMailer/src/Exception.php';
require __DIR__ .'/PHPMailer/src/SMTP.php';

function DisplayErrors() {
    global $errors;
    echo "<html>";
        echo "<head>";
            include('link.php');
            echo "<title>EpicElectro | Error</title>";
        echo "</head>";
        echo "<body>";
            echo "<div class='error'>";
            echo "<fieldset>";
            echo "<legend style='color: var(--red);'>Could Not Process Data</legend>";
            echo "<h3>The following errors found in data inputs</h3>";
            echo "<ul>";
            foreach($errors as $v) {
                echo "<li> <mark>&nbsp;$v&nbsp;</mark> </li>";
            }
            echo "</ul>";
            echo "</fieldset>";
            echo "<a id='eback' href=javascript:history.back()> Go Back </a></b> <br>";
            echo "</div>";
        echo "</body>";
    echo "</html>";
}


function fdate($txt) {
    [$year, $month, $day] = explode("-", $txt);
    return ($day."/".$month."/".$year);
}


function fdateTime($txt, $is24Hrs=false) {
    [$date, $time] = explode(" ", $txt);

    [$year, $month, $day] = explode("-", $date);
    $date = ($day."/".$month."/".$year);

    if (!$is24Hrs) {
        $time = date('h:i:s A', strtotime($time));
        [$time, $meridiem] = explode(" ", $time); // exploded to use span on AM/PM and make it small
        $time = $time."&nbsp;"."<span>$meridiem</span>";
    }
    
    return $date."&nbsp;|&nbsp;".$time;
}


function email($mailSubject, $mailBody, $mailAddress, $mailCopy=false) {
    $mail = new PHPMailer();

    $mail->isSMTP(); 
    $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 587; // TLS only
    $mail->SMTPSecure = 'tls'; // ssl is deprecated
    $mail->SMTPAuth = true;                               //Enable SMTP authentication
    $mail->Username   = 'epicelectro.store@gmail.com';    //SMTP username
    $mail->Password   = 'xsxgnggiwwkmgmic';               //SMTP password

    //Recipients
    $mail->setFrom('epicelectro.store@gmail.com');
    $mail->addAddress($mailAddress);     //Add a recipient
    if ($mailCopy) {$mail->addCC('epicelectro.store@gmail.com');}

    //Content
    $mail->isHTML(true);   //Set email format to HTML
    $mail->Subject = $mailSubject;
    $mail->Body    = $mailBody;

    $mail->send();
}
?>