<div class="m-auto">
    <form class="form-inline justify-content-center" method="post" id="search-form" action="<?= base_url('student/search_results');?>">
            <input class="form-control mx-2" name="location_home" id="location_home" placeholder="Where would you like to stay?" required="">
            <select class="form-control mx-2" name="hostel_type" id="hostel_type" required="">
                <option value="">Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <div class="input-group mx-2">
                <input class="form-control" type="number" name="max_price" id="max_price" placeholder="Maximum Price?">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary form-control" name="search_submit" id="search_submit">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
    </form>
</div>