    Dropzone.options.dropzoneFrom = {
        autoProcessQueue: true, //Stops immediate file upload
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg"
    };

    Dropzone.autoDiscover = false;

$(document).ready(function () {
    
    //list_image();
    
    /*****Action: Display images********/
    function list_image() {
        $.ajax({
            url: base_url + "owner/fetch_photos",
            dataType:"JSON",
            success: function (data) {
                $('#preview').html(data);
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    }
    /*****End: Display images********/

    var dropzone = new Dropzone('#dropzoneFrom');

    /***Dropzone action listeners***/
    dropzone.on('complete', function () {
        setTimeout(function () {
            list_image();
            dropzone.removeAllFiles();
        }, 2000);
    });

    dropzone.on('error', function () {
        $("#upload_error").slideDown().delay(3000).slideUp();
    });
    
    $("#edit-photos-tab").click(function(){
        list_image();
    });
    
    /***End: Dropzone action listeners***/


    /**Action: Remove image**/ 
    $(document).on('click', '.remove_image', function () {
        var name = $(this).attr('id');
        
        $.ajax({
            url: base_url+"owner/remove_image",
            method: "POST",
            dataType: "JSON",
            data: {name: name},
            success: function (data)
            {
                //Fetch images and uploads on image
                list_image();
            },
            error:function(xhr,textStatus,errorThrown){
                console.log(xhr.responseTxt);
            }
        });
        
    });

    

});