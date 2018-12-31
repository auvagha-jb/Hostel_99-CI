<?php
    $_SESSION['hostel_no'] = $_GET['id'];
    $_SESSION['type'] = $_GET['type'];

    //See dashbord controller to see where data is being obtained
    $_SESSION['hostel_name'] = $row['hostel_name'];

    if (isset($image)) {
        $_SESSION['prev_image_name'] = $row['image'];
    } else {
        $_SESSION['prev_image_name'] = "";
    }
?>
<!--Custom Js-->
<script src="<?= assets_url('js/owner/owner-edit.js'); ?>"></script>
<script src="<?= assets_url('js/owner-upload.js'); ?>"></script>
<!---->
<script src="<?= assets_url('js/manage-tenants.js'); ?>"></script>
<script src="<?= assets_url('js/manage-tenants-extended.js'); ?>"></script>
<script src="<?= assets_url('js/show-bookings.js'); ?>"></script>
<!---->
<!--Custom Js-->


<div id="wrapper" class="toggled">    
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="nav flex-column sidebar-nav" id="myTab" role="tablist">
            <li class="sidebar-brand sidebar-title">
                <span id="home-tab" class=""><?= $row['hostel_name']; ?></span>
            </li>
            <li>
                <a class="active border-bottom border-dark" id="community-tab" data-toggle="tab" href="#community" role="tab" aria-controls="community" aria-selected="true">
                    <i class="fas fa-users"></i> My Community</a>
            </li>
            <li>
                <a class="border-bottom border-dark" id="edit-details-tab" data-toggle="tab" href="#edit-details" role="tab" aria-controls="edit-details" aria-selected="false">
                    <i class="fa fa-pencil-alt"></i> Edit Details</a>
            </li>
            <li>
                <a class="border-bottom border-dark" id="edit-photos-tab" data-toggle="tab" href="#edit-photos" role="tab" aria-controls="edit-photos" aria-selected="false">
                    <i class="fa fa-camera"></i> Edit photos</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle"><i class="fas fa-bars"></i></a>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="community" role="tabpanel" aria-labelledby="community-tab"><?php community(); ?></div>
                <div class="tab-pane fade" id="edit-details" role="tabpanel" aria-labelledby="edit-details"><?php edit_hostel(); ?></div>
                <div class="tab-pane fade" id="edit-photos" role="tabpanel" aria-labelledby="edit-photos"><?php edit_photos(); ?></div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

</body>
</html>
