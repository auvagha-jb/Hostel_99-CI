function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var image = document.getElementById("preview_img");
            image.src = e.target.result;
            image.style.display = "block";  
            $('#image_display').hide();
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
                alert("Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", "));
                oInput.value = "";
                $('#image_display').show();
                return false;
            }
        }
    }
    readURL(oInput);
    return true;
}
