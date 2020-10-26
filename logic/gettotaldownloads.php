<?php


    require_once '../db/db.php';


    $ip = $_POST['ip'];

    $sql = "SELECT * FROM `files` WHERE `senderip`='$ip'";
    $result = mysqli_query($con, $sql);

    $number_of_downloads = mysqli_num_rows($result);

    echo $number_of_downloads;

