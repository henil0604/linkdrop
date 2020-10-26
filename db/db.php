<?php


$server = "localhost";
$user = "root";
$dbpassword = "";
$db = "linkdrop";

$con = mysqli_connect($server, $user, $dbpassword, $db);


if ($con) {
} else {
    $_SESSION['msg'] = "No Internet Connection";
}
