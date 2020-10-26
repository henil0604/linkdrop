<?php

    require '../db/db.php';

    $fileid = $_POST['fileid'];
    $ip = $_POST['ip'];

    $sql = "INSERT INTO `downloads`(`fileid`, `ip`) VALUES ('$fileid', '$ip')";
    $result = mysqli_query($con, $sql);



?>