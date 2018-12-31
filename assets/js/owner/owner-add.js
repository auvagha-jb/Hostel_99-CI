function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var image = document.getElementById("image_display");
            image.src = e.target.result;
            image.style.display = "block";  
        };
        reader.readAsDataURL(input.files[0]);
    }
}


function ValidateSingleInput(oInput) {
    var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];    
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Only image files can be uploaded");
                oInput.value = "";
                $('#image_display').attr('src','#');
                $('#image_display').css('display','none');
                return false;
            }
        }
    }
    readURL(oInput);
    $('#image_display').addClass('display_size');
    return true;
}
