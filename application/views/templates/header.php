<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="<?= base_url('img/hostel-logo.png');?>">

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.css');?>" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/css/sb-admin.css');?>" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/simple-sidebar.css');?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/tools/bootstrap-4.0.0-dist/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/tools/jquery-ui-1.12.1/jquery-ui.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/tools/dropzone/dropzone.css');?>">


    <script src="<?= base_url('assets/tools/jquery/jquery-3.3.1.js');?>"></script>
    <script src="<?= base_url('assets/tools/popper/popper.min.js');?>"></script>
    <script src="<?= base_url('assets/tools/bootstrap-4.0.0-dist/js/bootstrap.min.js');?>"></script>
<!--    <script src="<?= base_url('assets/tools/font-awesome/all.js');?>"></script>-->
    <script src="<?= base_url('assets/tools/angular-js/angular.min.js');?>"></script>
    <script src="<?= base_url('assets/tools/angular-js/angular-animate.min.js');?>"></script>
    <script src="<?= base_url('assets/tools/angular-js/angular-route.min.js');?>"></script>
    <script src="<?= base_url('assets/tools/jquery-ui-1.12.1/jquery-ui.js');?>"></script>
    <script src="<?= base_url('assets/tools/dropzone/dropzone.js');?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js');?>"></script>
    <!-- Page level plugin JavaScript-->
    <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.js');?>"></script>
    <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.js');?>"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/js/sb-admin.min.js');?>"></script>
    <!-- Demo scripts for this page-->
    <script src="<?= base_url('assets/js/demo/datatables-demo.js');?>"></script>
    <!-- Menu Toggle Script -->
     <script src="<?= base_url('assets/js/owner-table.js');?>"></script>

<!--     Common Links-->
    <link href="<?= assets_url('css/style.css');?>" rel="stylesheet">
    <script src="<?= assets_url('js/nav-bar.js');?>"></script>
    <script type="text/javascript">
        var base_url = "<?= base_url();?>";
    </script> 
    
    <?php
    //To ensure the session is still running and that the user accesses the right module
    user_verify(); 
    
    //Custom Links
    if (isset($css)) {
        setCSS($css);
    }
    ?>
    <title><?=$header['title'];?></title>
</head>
<body>
<!-- Navigation -->
<!--We're referencing md because that's the breakpoint-->
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <div class="container-fluid"> <!--So it takes up 100% of the screen-->
        <a class="navbar-brand" href="<?= base_url('Main/');?>"><img src="<?= assets_url('img/hostel-logo.png');?>" style="height: 60px; width: 60px;" alt="">Hostel 99</a>
        
        <!--Navigation button The id is here is generic-->
        <button type="button" class="navbar-toggler" id="nav-btn" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span><!--The nav button icon-->
        </button>

        <!--Class for collapsible nav bar-->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <!--Pushes list items to the right as opposed to the middle at full width-->

            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Main');?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Main/contact_us');?>">Contact us</a>
                </li>
                <!--FUnction in page_sections helper class-->
                <?php toggleNav(); ?>
            </ul>
        </div>
    </div>
</nav>
<?php

    
    function toggleNav(){
    //If the user is logged in
    if(isset($_SESSION['user_id'])){
        $id= $_SESSION['user_id'];
        $first_name = $_SESSION['first_name'];
        $user_type = $_SESSION['user_type'];
        
        if($user_type == "Student"){
            echo '
                    <li class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#">'.$first_name.'</a>
                        <div class="dropdown-content">
                            <a class="nav-link" href="student-view-details.php">My Details</a>
                            <a class="btn btn-danger" href="'.base_url('main/logout').'">Sign out</a>
                        </div>
                    </li>
                    ';
        }else if($user_type == "Hostel Owner"){
            echo '
                <li class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle dropdown-toggle" href="#">My Hostels</a>
                        <div class="dropdown-content">
                            <a class="nav-link" href="'.base_url('owner/add_hostel').'">Add</a>
                            <a class="nav-link" href="'.base_url('owner/view_hostels').'">View</a>
                        </div>
                    </li>
                <li class="dropdown">
                    <a class="btn btn-primary dropdown-toggle" href="#">'.$first_name.'</a>
                    <div class="dropdown-content">
                        <a class="btn btn-danger" href="'.base_url('main/logout').'">Sign out</a>
                    </div>
                </li>
                ';
        }
    }else{
        echo '
            <li class="nav-item">
                <a class="btn btn-dark" href="'.base_url('Main/sign_up').'">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="btn btn-outline-primary" href="'.base_url('Main/sign_in').'">Sign in</a>
            </li>   
            ';
    }
}
    
?>