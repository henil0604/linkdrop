function download(fileid) {
    $.post("adddownload.php", {
        fileid: fileid,
        ip
        },
        function(data, status) {
            console.log(data)
        }
    );


}