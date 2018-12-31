
<div class="container-fluid padding">
    <div class="row padding">        
    <?php
        if($query->num_rows()>0){
            showCards($query);
        }else{
            noHostelsMsg();
        }
        
        function showHeader(){            
            echo '
                <div class="col-12">
                    <div class="section-title">
                         <div class="lead">My Hostels</div>
                    </div>
                </div>
            ';
        }
        
        function showCards($query){
            showHeader();
            
            foreach ($query->result_array() as $row){
                $image = $row['image'];
                
                $id = $row['hostel_no'];
                $hostel_name = $row['hostel_name'];
                $location = $row['location']; 
                $road = $row['road'];
                $type = $row['type'];
                $path = $hostel_name."/".$image;
                
                echo '
                <div class="col-md-4 special-offers"> 
                    <div class="card">
                        <img class="card-img-top" src="'.uploads_url($path).'"> <!--Since the image is at the top-->
                        <div class="card-body">
                            <h4 class="card-title">'.$hostel_name.'</h4>
                            <p class="card-text">'.$road.', '.$location.'</p>   
                            <a href="'.base_url('owner/dashboard?id='.$id.'&type='.$type.'&hostel_name='.$hostel_name.'').'" class="btn btn-outline-dark">Manage</a>
                        </div>
                    </div>
                </div>
                ';
            }
        }
        
        function noHostelsMsg(){
            echo '
            <div class="lead m-auto pb-3">
                Nothing to see here yet!
                Add a hostel 
                    <a href="'.base_url('owner/add-hostel').'">here</a>
            </div>
            ';
        } 
        
    ?>    
        </div>
    </div>
</body>
</html>