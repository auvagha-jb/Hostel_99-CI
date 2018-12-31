<?php
    $_SESSION['hostel_no'] = $_GET['id']; 
    $_SESSION['hostel_name'] = $_GET['hostel_name'];
    $_SESSION['type'] = $_GET['type'];
?>

  
<!--Hostel header-->
<div class="hostel-title">
    <h4><?= $hostel['hostel_name']; ?></h4>
</div>

<!--Image Slider-->
<div id="slides" class="carousel slide" data-ride="carousel">
    <!-- The slideshow -->
    <?php student_carousel(); ?>
    <!-- Left and right controls -->
    <a class="carousel-control-prev" href="#slides" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </a>
    <a class="carousel-control-next" href="#slides" data-slide="next">
        <span class="carousel-control-next-icon"></span>
    </a>
</div>

<!--==Hostel Amenities==-->
<div class="hostel-description">
    <div id="about">
        <h4 class="text-muted">About this hostel</h4>
    </div>
    <p><?= $hostel['description']; ?></p>
</div>

<hr>
<!--==Hostel Amenities==-->
<div class="hostel-amenities">
    <div class="col-sm-3">
    <span class="text-muted">
      <i class="fas fa-tv" aria-expanded="true"></i>
      Amenities
    </span>
    </div>
    <div class="col-sm-9">
        <div>
            <ul class="hostel-data">
                <?php 
                foreach($amenities->result_array() as $row){
                    echo "<li>".$row['amenity']."</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<hr>
<!--==Hostel Rules==-->
<div class="hostel-rules">
    <div class="col-sm-3">
        <span class="text-muted">
          <i class="fas fa-check" aria-expanded="true"></i>
          House Rules
        </span>
    </div>
    <div class="col-sm-9">
        <div>
            <ul class="hostel-data">
                <?php 
                foreach($rules->result_array() as $row){
                    echo "<li>".$row['rule']."</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<hr>
<!--==Hostel Room pricing==-->
<div class="hostel-pricing">
    <div class="col-sm-3">
        <span class="text-muted">
          <i class="fas fa-money-bill-alt" aria-expanded="true"></i>
          Pricing
        </span>
    </div>
    <div class="col-sm-9">
        <div>
            <ul class="pricing-list">
                <?php
                    foreach($pricing->result_array() as $row){
                        echo '<li class="pricing-item">'
                                . '<span>'
                                    . '<strong>'.$row['no_sharing'].' Sharing </strong> Kshs. '.$row['monthly_rent'].' per month
                                </span>
                                <a href="'.base_url('student/add_to_cart?&id='.$row['hostel_no'].'&no='.$row['no_sharing']).'" class="btn btn-success">
                                    <i class="fas fa-bookmark"></i> Book this room
                                </a>
                            </li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</div>
