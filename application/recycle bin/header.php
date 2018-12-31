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
    
    <title><?=$data['title'];?></title>

        