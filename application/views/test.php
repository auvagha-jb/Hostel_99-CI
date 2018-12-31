<?php

?>
<div class="my-2">
    <form method="post" class="add-hostel-form" action="<?= base_url('owner/test_upload'); ?>" 
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" id="image" class="form-control" required/>
            <input type="submit" name="submit" class="btn btn-primary" value="Upload"/>
        </div>
    </form>
</div>

<div class="my-2">
    <form method="post" class="add-hostel-form" action="<?= base_url('owner/test_mkdir'); ?>" 
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Folder name</label>
            <input type="text" name="folder" id="folder" class="form-control" required/>
            <input type="submit" name="submit" class="btn btn-primary" value="Mkdir"/>
        </div>
    </form>
</div>

<div class="my-2">
    <form method="post" class="add-hostel-form" action="<?= base_url('owner/test_rename'); ?>" 
          enctype="multipart/form-data">
        <div class="form-group">
            <label>Folder name</label>
            <input type="text" name="folder" id="folder" class="form-control" required/>
            <input type="submit" name="submit" class="btn btn-primary" value="Rename"/>
        </div>
    </form>
</div>

            