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

                <div class="alert alert-danger" id="uploadfail" role="alert">
                    <b>Failed To Upload File!!! Please Try Again...</b>
                </div>  

                <div id="maxlimit" class="alert alert-danger" role="alert">
                    <b id="maxlimitB">Reached Limit!!! Please Choose File Under 10 Mb...</b>
                </div>  

                <p>
                    Supported File Formats: .pdf, .docx, .rtf, .jpg, .jpeg, .png, .exe, .apk
                </p><br>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4 form-group">
                        <h3 class="text-center">Upload File</h3>
                    </div>
                    <!--form-group-->
                </div>
                <!--row-->
                <form>
                    <div id="uploader">
                        <div class="row uploadDoc">
                            <div class="col-sm-11">
                                <div class="docErr">Please upload valid file</div>
                                <!--error-->
                                <div class="fileUpload btn btn-orange">
                                    <img src="https://image.flaticon.com/icons/svg/136/136549.svg" class="icon">
                                    <span class="upl" id="upload">Upload document</span>
                                    <input type="file" name="file" class="upload up" id="up" onchange="readURL(this);" />
                                </div><!-- btn-orange -->
                            </div><!-- col-3 -->
                            <!--col-8-->
                            <div class="col-sm-1"><a class="btn-check"><i class="fa fa-times"></i></a></div><!-- col-1 -->
                        </div>
                        <!--row-->
                    </div>

                    <div class="range-slider">
                        <span><b>Max Download Limit:</b></span>
                        <input class="range-slider__range" oninput="range(this.value)" type="range" value="100" min="1" max="1000">
                        <span class="range-slider__value" name="maxdownloadlimit" id="range-slider__value">0</span>
                    </div>

                    <div class="progress progress-striped active">
                        <div class="progress-bar" style="width:0%"></div>
                    </div>

                    <!--uploader-->
                    <div class="text-center" id="createLink">
                        <button type="submit" class="btn btn-next createlink"><i class="fa fa-paper-plane"></i> Create Link</button>
                        <button class="btn btn-next reacheduploadlimit" disabled><i class="fa fa-paper-plane">You Reached The Upload Limit</i></button>
                        <button class="btn btn-next storagefull" disabled><i class="fa fa-paper-plane">Your Storage is Full</i></button>
                        <!-- <button class="btn btn-next cancel"><i class="fa fa-paper-plane"></i>Cancel</button> -->
                    </div>

                </form>
            </div>
            <!--one-->
        </div><!-- row -->
    </div><!-- container -->



    <?php require '../links/footer.html'; ?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
    <script src="http://malsup.github.com/jquery.form.js"></script> 
    <script src="../js/upload.js"></script>
    <script>
        var maxuploadstorage_mb = 1000
        maxuploadstorage_byte = maxuploadstorage_mb * 1048576

        function range(value){
            if(value >= 1000){
                document.getElementById("range-slider__value").innerHTML = "Unlimited"
            }else{
                document.getElementById("range-slider__value").innerHTML = value
            }
        }


        function gettotaldownloads(){
            $.post("../logic/gettotaldownloads.php", {
                ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>",
            },
            function(data, status) {
                if(data > maxfileuploads){
                    $(".reacheduploadlimit").show()
                    $(".createlink").hide()
                }else{
                    $(".reacheduploadlimit").hide()
                    $(".createlink").show()
                }
            });
        }

        function gettotaluploadedstorage(){
            $.post("../logic/gettotaluploadedstorage.php", {
                ip: "<?php echo $_SERVER['REMOTE_ADDR']; ?>",
            },
            function(data, status) {
                console.log(data)
                if(parseInt(data) > maxuploadstorage_byte){
                    $(".storagefull").show()       
                    $(".createlink").hide()       
                }else{
                    $(".storagefull").hide()       
                    $(".createlink").show()  
                }
            });
        }


        // gettotaldownloads()
        gettotaluploadedstorage()
        range(100)



    </script>

</body>

</html>