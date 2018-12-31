<?php 
            $user_id;
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION['user_id']; 
            }else{
                $user_id = "";
            }    
            ?>
            <input type="hidden" id="user_id" value="<?= $user_id;?>">
            
        </div>
    </div>
  
           
<!--- Three Column Section -->
<div class="container-fluid padding">
    <div class="partners">
        
        <!--Title-->
        <div class="col-12">
            <div class="section-title">
                <div class="display-4">
                    Our Esteemed Partners
                </div>
            </div>
        </div>
        
        <!--Partner logos-->
    <div class="row text-center-padding">
            <div class="col-xs-6 col-sm-6 col-md-3">
                <img src="<?= base_url('assets/img/partners/strathmore-university.jpg');?>">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3">
                <img src="<?= base_url('assets/img/partners/uon-logo.png');?>">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3">
                <img src="<?= base_url('assets/img/partners/jkuat.jpg');?>">
            </div>
            <div class="col-xs-6 col-sm-6 col-md-3">
                <img src="<?= base_url('assets/img/partners/kenyatta-university_Logo.png');?>">
            </div>    
    </div>
    </div> 
</div>

<hr class="my-4">
<!--- Two Column Section -->
 

<!--- Fixed background -->


<!--- Emoji Section -->

  
<!--- Meet the team -->


<!--- Cards -->
<div class="container-fluid padding">
    <div class="row padding">
        <div class="col-12">
            <div class="section-title">
                 <div class="display-4">Special Offers</div>
            </div>
        </div>
        <div class="col-md-4 special-offers"> <!--Since it's changing at the 768px mark-->
            <div class="card">
                <img class="card-img-top" src="assets/img/travelers-oasis.jpg"> <!--Since the image is at the top-->
                <div class="card-body">
                    <h4 class="card-title">Travelers oasis</h4>
                    <p class="card-text">
                        Located in Nairobi, within 8 km of Kenyatta International Conference Centre and 
                        10 km of Nairobi National Museum, Travelers oasis offers accommodation with a shared 
                        lounge. Located around 1.8 km from Century Cinemax Junction, the hostel is also 1.8 
                        km away from Junction Mall Nairobi. The property is a 17-minute walk from Adams 
                        Arcade Shopping Centre.
                    </p>
                    <a href="#" class="btn btn-outline-primary">Book Now</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 special-offers"> <!--Since it's changing at the 768px mark-->
            <div class="card">
                <img class="card-img-top" src="assets/img/westlands-backpackers.jpg"> <!--Since the image is at the top-->
                <div class="card-body">
                    <h4 class="card-title">Westlands Backpackers</h4>
                    <p class="card-text">
                        Featuring a garden, Westlands Backpackers in Nairobi is set 3.5 km from Nairobi 
                        National Museum. Among the various facilities of this property are a terrace and a 
                        shared lounge. Kenyatta International Conference Centre is 5 km from the hostel.
                    </p>
                    <a href="#" class="btn btn-outline-primary">Book Now</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 special-offers"> <!--Since it's changing at the 768px mark-->
            <div class="card">
                <img class="card-img-top" src="assets/img/KG-ladies-hostel.jpg"> <!--Since the image is at the top-->
                <div class="card-body">
                    <h4 class="card-title">Karen Gardens Ladies Hostel</h4>
                    <p class="card-text">
        Located in Nairobi, within 11 km of Kenyatta International Conference Centre and 12 km of Nairobi 
        National Museum, Karen Gardens Ladies Hostel offers accommodation with a garden, free WiFi. Boasting a 
        24-hour front desk, this property also provides students with a restaurant. The property is 2.8 km from 
        Hardy Shopping Centre Karen.
                    </p>
                    <a href="#" class="btn btn-outline-primary">Book Now</a>
                </div>
            </div>
        </div>
        
    </div>
</div>
