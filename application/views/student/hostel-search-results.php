<!--Custom JS-->
    <script src="<?= assets_url('js/main.js');?>"></script>
<!--Custom JS-->


<div class="container-fluid padding">
    <div class="row padding">

        <!--Since it's changing at the 768px mark-->
        <?php
        //Query loaded from student model in controller 
        $no_results = $query->num_rows();

        //If at least one result is found 
        if ($no_results > 0) {
            resultsFeedback($no_results);
            showCards($query);
        } else {//If no results are found
            noResults();
        }

        function resultsFeedback($no_results) {
            echo '
                <div class="col-12">
                    <div class="section-title">
                         <div class="lead">' . $no_results . ' results found</div>
                    </div>
                </div>
            ';
        }

        function showCards($query) {
            foreach ($query->result_array() as $row) {
                /***Query data****/
                $id = $row['hostel_no'];
                $hostel_name = $row['hostel_name'];
                $folder = "uploads/";
                $image = $row['image'];
                $description = $row['description'];
                $location = $row['location'];
                $road = $row['road'];
                $monthly_rent = $row['monthly_rent'];
                $type = $row['type'];
                //$no_sharing = $row['no_sharing'];
                $vacancies = $row['vacancies'];
                $vacancy_msg = "";
                /*                 * **End: Query data*** */

                if ($vacancies == 0) {
                    $vacancy_msg = "FULLY BOOKED";
                } else {
                    $vacancy_msg = 'Vacancies <span class="border px-2">' . $vacancies . '</span>';
                }

                echo '
                <div class="col-md-4"> 
                    <div class="card">
                        <img class="card-img-top" src="'.uploads_url($hostel_name . "/" . $image).'"> <!--Since the image is at the top-->
                        <div class="card-body">
                            <p class="card-text float-right text-sm border border-dark p-2">' . $type . '</p>
                            <h4 class="card-title">' . $hostel_name . '</h4>
                            <p class="card-text">' . $road . ', ' . $location . '</p>
                            <p class="card-text">Rent from: Kshs ' . $monthly_rent . ' Per Month</p>
                            <p class="card-text">' . $vacancy_msg . '</p>
                            <a href="' . base_url('student/book?id=' . $id . '&hostel_name=' . $hostel_name . '&type=' . $type) . '" 
                                class="btn btn-outline-primary" id="book_now">Book Now</a>
                        </div>
                    </div>
                </div>
                ';
            }
        }

        function noResults() {
            echo '
            <div class="lead m-auto pb-3">No results found! </div>
        ';
            search_results();
        }
        ?>
        <input type="hidden" id="user_id" value="<?= $_SESSION['user_id']; ?>">     
    </div>
</div>
</body>
</html>