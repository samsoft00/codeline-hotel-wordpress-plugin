<?php 
    $title = "Room Reservation";
    //include external header
    include_once('header.php');

    include_once('includes/header_bar.php');

    $start_date     = date_create($_REQUEST['start_date']);
    $end_date       = date_create($_REQUEST['end_date']);
    $dayDiff        = date_diff($end_date, $start_date);    

    //get list of available rooms
    $requests = wp_remote_get(CL_BASE_API_URL.'/rooms/'.$_REQUEST['rooms']);

    if( is_wp_error( $request ) ) {
        die('Unable to access remote resources');
    }

    $room = json_decode( $requests ['body'] );
    $IMAGE_PATH = CL_BASE_IMAGE_URL;

    $params = [
        'room_id'       =>  $_REQUEST['rooms'],
        'room_type'     =>  $_REQUEST['room_type'],
        'end_date'      =>  $_REQUEST['end_date'],
        'start_date'    =>  $_REQUEST['start_date'],
        'total'         =>  $room->type->cost->price * $dayDiff->days,
        'days'          =>  $dayDiff->days
    ]; 
    // var_dump($params);die;
?>


<div class="container">

    <h1>Room Reservation</h1>
    <hr/>
    <div class="row">
        <div class="col-md-8 order-md-1">
            <!--
            - Customer details form:
            - Customer Fullname (required)
            - Customer Phone (required)
            - Confirmation button to book the selected room.
            - Protect form submission with Google ReCaptcha
            -->

            <form action="" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                    </div>
                </div> 
                <div class="mb-3">
                    <label for="address">Phone Number</label>
                    <input type="text" class="form-control" id="address" placeholder="Phone number" required="">
                </div> 
                <div class="mb-3">
                    <label for="address">Email Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Email Address" required="">
                </div>
                <div class="g-recaptcha" data-sitekey="6LcKHuESAAAAAAl5AuZee9WPM61ozD4DYTtBsvPC"></div>
                <hr class="mb-4">
                <button class="btn btn-danger btn-block" type="submit">Continue to checkout</button>
            </form>

        </div>
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted"><?php echo "Rooms ".$room->name ?></span>
                <span class="badge badge-secondary badge-pill">1</span>
            </h4>
            <ul class="list-group mb-3">                
            <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div style="height:156px;">
                    <img src="<?php echo $IMAGE_PATH.$room->image ?>" style="height:156px" alt="">
                </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">Room Type</h6>
                <small class="text-muted"><?php echo $room->type->type ?></small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">Room Capacity</h6>
                <small class="text-muted"><?php echo $room->capacity->name ?></small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between bg-light">
              <div class="text-success">
                <h6 class="my-0">Duration</h6>
                <small>
                    <?php echo $params['start_date'] ?>  - 
                    <?php echo $params['end_date'] ?>
                </small>
              </div>
            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (USD)</span>
              <strong><?php echo "$".$params['total'] ?></strong>
            </li>
          </ul>                    
        </div>
    </div>
</div>

<?php include_once('footer.php'); ?>