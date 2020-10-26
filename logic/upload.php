<?php



    require '../db/db.php';





    $tmp_file = $_FILES['file']['tmp_name'];

    $filename = $_FILES['file']['name'];

    $filesize = $_FILES['file']['size'];

    $fileid = getId(10);

    $senderip = $_SERVER['REMOTE_ADDR'];



    $file_ext = explode('.', $filename);

    $file_ext = strtolower(end($file_ext));

    $maxdownloadlimit = $_GET['maxdownloadlimit'];




    $sql = "INSERT INTO `files`(`fileId`, `filename`, `filesize`, `senderip`) VALUES ('$fileid', '$filename', '$filesize', '$senderip')";

    $sql2 = "INSERT INTO `filesettings`(`fileId`, `maxdownloadlimit`) VALUES ('$fileid', '$maxdownloadlimit')";



    $move = move_uploaded_file($tmp_file, '../Media/' . $fileid . '.' . $file_ext);



    if($move){

        $result = mysqli_query($con, $sql);
        $result = mysqli_query($con, $sql2);

        echo $fileid;

    }else{

        echo 'fileuploadfail';

    }



    function getId($length){

        $id = "";

        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";

        $codeAlphabet.= "0123456789";

        $codeAlphabet.= "-_";  // Special characters allowed in url

        $max = strlen($codeAlphabet);


        for ($i=0; $i < $length; $i++) {

            $id .= $codeAlphabet[random_int(0, $max-1)];

        }


        // isId($id);


        return $id;

    }

    

    function isId($id){

        global $con;

        $sql = "SELECT * FROM `files` WHERE `fileid`='$id'";

        $result = mysqli_query($con, $sql);

        $num = mysqli_num_rows($result);

        if ($num == 0){

        }else{
            getId(10);
        }

    }
