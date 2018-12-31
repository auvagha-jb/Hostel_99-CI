<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="tenants-tab" data-toggle="tab" href="#tenants" role="tab" aria-controls="tenants" aria-selected="true">Tenants</a>
    <a class="nav-item nav-link" id="bookings-tab" data-toggle="tab" href="#bookings" role="tab" aria-controls="bookings" aria-selected="false">Bookings</a>
    <a class="nav-item nav-link" id="rooms-tab" data-toggle="tab" href="#rooms" role="tab" aria-controls="rooms" aria-selected="false">Rooms</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="tenants" role="tabpanel" aria-labelledby="tenants-tab"><?php view_tenants(); ?></div>
    <div class="tab-pane fade" id="bookings" role="tabpanel" aria-labelledby="bookings-tab"><?php view_bookings(); ?></div>  
    <div class="tab-pane fade" id="rooms" role="tabpanel" aria-labelledby="rooms-tab"><?php view_rooms();?></div>  
</div>