<?php



require '../db/db.php';



$f = $_GET['f'];
if(isset($_GET['downloadable'])){
    $downloadable = $_GET['downloadable'];
}else{
    $downloadable = true;
}


$sql = "SELECT * FROM `files` WHERE `fileid`='$f'";

$result = mysqli_query($con, $sql);



$row = mysqli_fetch_assoc($result);



$filename = $row['filename'];

$file_ext = explode('.', $filename);

$file_ext = strtolower(end($file_ext));

$filesize = $row['filesize'];

$senderip = $row['senderip'];


$sql = "SELECT * FROM `filesettings` WHERE `fileid`='$f'";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $maxdownloadlimit = $row['maxdownloadlimit'];
}



$sql = "SELECT * FROM `downloads` WHERE `fileid`='$f'";
$result = mysqli_query($con, $sql);

$totaldownloads = mysqli_num_rows($result);



if($maxdownloadlimit != "Unlimited" && $totaldownloads >= $maxdownloadlimit){
    $downloadable = false;
    $downloadlimitfull = true;
}


function formatSizeUnits($bytes){

    if ($bytes >= 1073741824)

    {

        $bytes = number_format($bytes / 1073741824, 2) . ' GB';

    }

    elseif ($bytes >= 1048576)

    {

        $bytes = number_format($bytes / 1048576, 2) . ' MB';

    }

    elseif ($bytes >= 1024)

    {

        $bytes = number_format($bytes / 1024, 2) . ' KB';

    }

    elseif ($bytes > 1)

    {

        $bytes = $bytes . ' bytes';

    }

    elseif ($bytes == 1)

    {

        $bytes = $bytes . ' byte';

    }

    else

    {

        $bytes = '0 bytes';

    }



    return $bytes;

}



?>



<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload File - LinkDrop</title>

    <?php require '../links/header.html'; ?>

    <link rel="stylesheet" href="../css/upload.css">

</head>



<body>





    <div class="container">

        <div class="row it">

            <div class="col-sm-offset-1 col-sm-10" id="one">

                <div class="row">

                    <div class="col-sm-offset-4 col-sm-4 form-group my-3">

                    <?php
                    if($downloadable == true){

                        echo '
                            <h3 class="text-center mx-auto">Download File:</h3>
                        ';

                    }else{}

                    ?>

                    </div>

                    <!--form-group-->

                </div>

                <!--row-->

                    <div id="uploader">

                        <div class="row uploadDoc">

                            <div style="text-align: center;">

                                <?php
                                    if($downloadable == true){

                                        echo '
                                            <a class="btn btn-success btn-large" href="../Media/ ' . $f .'.'. $file_ext .'>" download=" ' . $filename . '" id="downloadbtn" onclick="downloadfile(`'. $f .'`)">Download</a>
                                        ';

                                    }elseif($downloadable == false && $downloadlimitfull == true){

                                        echo '
                                            <b>Download Limit Exceeded!!!</b>
                                            <br>
                                            <button class="btn btn-success btn-large" disabled>Download</button>
                                        ';   

                                    }
                                ?>


                                <hr>



                                <div>

                                    <h4 class="mb-3"><u>File Info</u></h4>



                                    <h5><strong>Filename: </strong><span><?php echo $filename; ?></span></h5>



                                    <h5><strong>Filesize: </strong><span><?php echo formatSizeUnits($filesize); ?></span></h5>



                                    <h5><strong>Uploaded By: </strong><span><?php echo $senderip; ?></span></h5>



                                </div>





                            </div><!-- col-3 -->

                            <!--col-8-->

                        </div>

                        <!--row-->

                    </div>

                    <!--uploader-->

            </div>

            <!--one-->

        </div><!-- row -->

    </div><!-- container -->







    <?php require '../links/footer.html'; ?>

    <script>
        function downloadfile(fileid) {
            $.post("../logic/adddownload.php", {
                    fileid: fileid,
                    ip: '<?php echo $_SERVER['REMOTE_ADDR'] ?>'
                },
                function(data, status) {
                }
            );


        }

        
    </script>



</body>



</html>