var filesizeglobal;

var fileTypes = ['pdf', 'docx', 'rtf', 'jpg', 'jpeg', 'png', 'exe', 'apk'];  //acceptable file types
function readURL(input) {
    if (input.files && input.files[0]) {
        var extension = input.files[0].name.split('.').pop().toLowerCase(),  //file extension from input file
            isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types

        if (isSuccess) { //yes
            var reader = new FileReader();
            reader.onload = function (e) {
                if (extension == 'pdf'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/179/179483.svg');
                }
                else if (extension == 'docx'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/281/281760.svg');
                }
                else if (extension == 'rtf'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136539.svg');
                }
                else if (extension == 'png'){ $(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136523.svg'); 
                }
                else if (extension == 'jpg' || extension == 'jpeg'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136524.svg');
                }
                else if (extension == 'txt'){
                	$(input).closest('.fileUpload').find(".icon").attr('src','https://image.flaticon.com/icons/svg/136/136538.svg');
                }
                else {
                	$(input).closest('.uploadDoc').find(".docErr").slideUp('slow');
                }
            }

            reader.readAsDataURL(input.files[0]);
            filesizeglobal = formatFileSize(input.files[0].size);
            if (filesizeglobal == undefined || filesizeglobal == "undefined") {
                filesizeglobal = "NaN";
            }
            maxfilemb = 200
            maxfilebyte = maxfilemb * 1048576

            if(input.files[0].size > maxfilebyte){
                $("#createLink").hide()
                $("#maxlimitB").html(`Reached Limit!!! Please Choose File Under ${maxfilemb} Mb...`)
                $("#maxlimit").show()
            }
            else{
                $("#createLink").show()
                $("#maxlimit").hide()
            }

        }
        else {
            $(input).closest('.uploadDoc').find(".docErr").fadeIn();
            setTimeout(function() {
                $('.docErr').fadeOut('slow');
            }, 9000);
        }
    }
}

$(document).ready(function () {
    $("#maxlimit").hide()
    $(".reacheduploadlimit").hide()
    $("#uploadfail").hide()
    $(".progress").hide()
    // $(".cancel").hide()
   
   $(document).on('change','.up', function(){
   	var id = $(this).attr('id'); /* gets the filepath and filename from the input */
    var profilePicValue = $(this).val();
    var fileNameStart = profilePicValue.lastIndexOf('\\'); /* finds the end of the filepath */
    profilePicValue = profilePicValue.substr(fileNameStart + 1).substring(0,20); /* isolates the filename */
    // var profilePicLabelText = $(".upl"); /* finds the label text */
    if (profilePicValue != '') {
        $(this).closest('.fileUpload').find('.upl').html(profilePicValue + " (" + filesizeglobal + ")"); /* changes the label text */
    }
   });

});


function formatFileSize(bytes,decimalPoint=2) {
   if(bytes == 0) return '0 Bytes';
   var k = 1000,
       dm = decimalPoint || 2,
       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
       i = Math.floor(Math.log(bytes) / Math.log(k));
   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}



$(document).on('submit','form',function(e){
    e.preventDefault();

    $form = $(this);

    uploadFile($form);

});

function uploadFile($form){
    $(".progress").show()
    $(".cancel").show()

    $form.find('.progress-bar').removeClass('progress-bar-success')
                                .removeClass('progress-bar-danger');

    var formdata = new FormData($form[0]); //formelement
    var request = new XMLHttpRequest();
    var maxdownloadlimit = document.getElementById("range-slider__value").innerHTML;
    var url = '../logic/upload.php?maxdownloadlimit=' + maxdownloadlimit;

    //progress event...
    request.upload.addEventListener('progress',function(e){
        var percent = Math.round(e.loaded/e.total * 100);
        $form.find('.progress-bar').width(percent+'%').html(percent+'%');
    });

    //progress completed load event
    request.addEventListener('load',function(e){
        gettotaluploadedstorage()
        resText = this.responseText;
        console.log(resText)
        if (resText.includes("fileuploadfail")) {
            $form.find('.progress-bar').addClass('progress-bar-success').html('Upload Failed....');
            $("#uploadfail").show()
            console.log(resText)
        }
        else if (resText.length == 10) {
            $form.find('.progress-bar').addClass('progress-bar-success').html('Upload completed....');
            location.href = "../upload/share.php?f=" + resText;
        }


    });

    request.open('post', url);
    request.send(formdata);

    $form.on('click','.cancel',function(){
        request.abort();

        $form.find('.progress-bar').removeClass('progress-bar-success').addClass('progress-bar-danger').html('upload aborted...');
    });

}
