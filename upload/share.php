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

                        <h3 class="text-center">Share File</h3>

                    </div>

                    <!--form-group-->

                </div>

                <!--row-->

                    <div id="uploader">

                        <div class="row uploadDoc">

                            <div style="display: flex;">

                                <input class="form-control mx-5" id="link" readonly="" value="http://linkdrop.epizy.com/download?f=<?php echo $_GET['f']; ?>">

                                

                                <button class="btn btn-primary" onclick="copy()" id="copyLink">Copy</button>

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

    <script src="../js/share.js"></script>



</body>



</html>