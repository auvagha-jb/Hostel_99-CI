<!--Owner activation - This is supposed to restrict people from creating unverified hostels in the system
  A random code is generated
  The hostel name is recorded
  An email is sent to the particular user with the hostel name and code they generated
-->

<!--Dropdown message to give feedback-->
<center class="alert alert-success fixed-top hide" id="owner-reg-feedback"></center>

<!--Inner navigation bar to switch between tables-->
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="registration-form-tab" data-toggle="tab" href="#registration-form" role="tab" aria-controls="registration-form" aria-selected="true">Add</a>
        <a class="nav-item nav-link" id="registered-owners-tab" data-toggle="tab" href="#registered-owners" role="tab" aria-controls="registered-owners" aria-selected="true">Registered Owners</a>
    </div>
</nav>

<!--Tab wrapper-->
<div class="tab-content" id="nav-tabContent">

    <!--The registration form-->
    <div class="tab-pane fade show active" id="registration-form" role="tabpanel" aria-labelledby="registration-form-tab">
        <!--Owner registartion form-->
        <div class="container-fluid padding">
            <form method="post" action="<?= base_url('admin/register_owner'); ?>" class="sign-in" id="owner_reg_form">
                <div class="lead form-text">Register Owner</div>
                <div class="form-group">
                    <label>Hostel name</label>
                    <input type="text" name="hostel_name" id="hostel_name" class="form-control" required="">
                    <div class="invalid-feedback">Hostel name already exists</div>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" name="email" id="email" class="form-control" required="">
                    <div class="invalid-feedback" id="email-feedback">Email already exists</div>
                </div>
                <div class="form-group">
                    <center>
                        <button type="button" id="generate_pwd_btn" class="btn btn-secondary">Generate password</button>
                    </center>
                </div>
                <div class="form-group">
                    <label>Generated Password</label>
                    <input type="text" name="activation_pwd" id="activation_pwd" class="form-control" readonly="" required="" placeholder="Click the button above">
                    <div class="invalid-feedback">Click the button to generate a random password</div>
                </div>
                <button  class="btn btn-primary" id="sign-in-btn">Register hostel</button>
            </form>
        </div>
    </div>
    <!--=========End=========-->

    <!--The registered owners table-->
    <div class="tab-pane fade show" id="registered-owners" role="tabpanel" aria-labelledby="registered-owners-tab">
        <div class="table-responsive">
            <table class='w3-table-all w3-centered w3-hoverable admin-table' id="registered-owners-table">
                <thead>
                    <?php headerRows(); ?>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <!--=========End=========-->

</div>
<!--End: Tab wrapper-->

<?php

function headerRows() {
    echo "<tr>";
    echo "<th>Serial No.</th>";
    echo "<th>Hostel Name</th>";
    echo "<th>Email Address</th>";
    echo "<th>Delete</th>";
    echo "</tr>";
}
?>