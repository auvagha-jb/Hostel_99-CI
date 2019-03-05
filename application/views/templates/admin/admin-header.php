<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $header['title']; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= assets_url('css/admin.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/tools/bootstrap-4.0.0-dist/css/bootstrap.min.css'); ?>">
        <link href="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.css'); ?>" rel="stylesheet">
        <script src= "https://cdn.zingchart.com/zingchart.min.js"></script>
        <script> zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>

        <script src="<?= base_url('assets/tools/jquery/jquery-3.3.1.js'); ?>"></script>
        <script src="<?= base_url('assets/tools/popper/popper.min.js'); ?>"></script>
        <script src="<?= base_url('assets/tools/bootstrap-4.0.0-dist/js/bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('assets/vendor/datatables/jquery.dataTables.js'); ?>"></script>
        <script src="<?= base_url('assets/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
        <script src="<?= assets_url('js/admin/admin.js'); ?>"></script>
        <script type="text/javascript">
            var base_url = "<?= base_url(); ?>";
        </script> 

        <?php
        //Helper method: To ensure the session is still running and that the user accesses the right module
        user_verify();

        //Custom Links
        if (isset($css)) {
            //Helper method: To past custom css link(s)
            applyCSS($css);
        }
        ?>
    </head>

    <body>
        <!-- Navbar -->
        <div class="w3-bar w3-border w3-black" style="height: 60px">
            <nav>
                <a href="<?= base_url('admin/'); ?>" class="w3-bar-item w3-button w3-text-teal">Home</a>
                <a href="<?= base_url('admin/users'); ?>" class="w3-bar-item w3-button">Users</a>
                <a href="<?= base_url('admin/hostels'); ?>" class="w3-bar-item w3-button">Hostels</a>
                <a href="<?= base_url('admin/owner_registration'); ?>" class="w3-bar-item w3-button">Register Owner</a>
                <a href="<?= base_url('main/logout'); ?>" class="w3-bar-item w3-button w3-red"  id="logout-btn" style="float: right;">Logout</a>
            </nav>
        </div>