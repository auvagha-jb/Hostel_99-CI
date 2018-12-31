<!--Carousel images-->
<div class="carousel-inner">
    <?php

    //Hostel data loaded in the contoller
    $hostel_name_ = $hostel['hostel_name'].'/';
    
    $path = 'uploads/' . $hostel_name_;

    if (file_exists($path)) {
        $handle = opendir($path);
        $first = true;
        $counter = 0;

        while ($file = readdir($handle)) {
            if ($file !== '.' && $file !== "..") {

                if ($first) {
                    echo '
                 <div class="carousel-item active">
                    <img src="' . uploads_url($hostel_name_ . $file) . '">
                </div>
               ';

                    $first = false;
                } else {
                    echo '
                     <div class="carousel-item">
                        <img src="' . uploads_url($hostel_name_ . $file) . '">
                    </div>
                   ';
                }
                $counter++;
            }
        }
    }
    ?>
</div>
<!--Carousel images-->


<!--Carousel indicators-->
        <ul class="carousel-indicators">
            <?php 
                $slide = 0;
                $li = "";
                while($slide<$counter){
                    if($slide == 0){
                        $li.= ' <li data-target="#slides" data-slide-to="'.$slide.'" class="active"></li>';
                    }  else {
                        $li.= ' <li data-target="#slides" data-slide-to="'.$slide.'"></li>';
                    }
                    $slide++;
                }
            ?>
        </ul>
<!--Carousel indicators-->