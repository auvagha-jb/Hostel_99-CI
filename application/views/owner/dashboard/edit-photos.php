
    <!--
        Dashboard contains the links needed
    -->
    <div id="upload_error" class="alert alert-warning fixed-top" style="top: 85px; text-align: center; display: none;">Only image files can be uploaded</div>
    <?php 
        $hostel_name = $_GET['hostel_name'];
        $_SESSION['hostel_name'] = $hostel_name;
    ?>
    <p class="title-centered">My photos</p>
    
    <form action="<?= base_url('owner/dropzone_upload');?>" class="dropzone" id="dropzoneFrom">
    </form>
    <br>
<!--    <center>
        <button id="submit-all" class="btn btn-primary">Upload</button>
    </center>-->
    <br>
    <div id="preview">
        
    </div>
    <br>
    <br>  
    