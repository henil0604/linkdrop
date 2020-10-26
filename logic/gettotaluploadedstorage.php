<?php


    require_once '../db/db.php';


    $ip = $_POST['ip'];

    $sql = "SELECT * FROM `files` WHERE `senderip`='$ip'";
    $result = mysqli_query($con, $sql);

    $totalsize = 0;

    while($row = mysqli_fetch_assoc($result)){

        $filesize = (int)$row['filesize'];

        $totalsize += $filesize;

    }

    echo $totalsize;
