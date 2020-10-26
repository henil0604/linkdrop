

function copy(){

    var link = document.getElementById("link")



    link.select()



    document.execCommand('copy');

    alert("Copied to clipboard");

}  

