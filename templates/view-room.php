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
    
    if(isset($_REQUEST['first_name']) && 
        isset($_REQUEST['last_name']) && 
        isset($_REQUEST['phone']) && 
        isset($_REQUEST['email'])){

            $firstname  = $_REQUEST['first_name'];
            $lastname   = $_REQUEST['last_name'];
            $phone      = $_REQUEST['phone'];
            $email      = $_REQUEST['email'];
            $captcha    = $_REQUEST['g-recaptcha-response'];
            $secretKey  = "";

            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $responseKeys = json_decode($response,true);

            // var_dump($responseKeys);
            if($responseKeys["success"]){

                $response = wp_remote_post(CL_BASE_API_URL."/book-room", [
                    'method'    =>  'POST',
                    'headers'   =>  ['Content-Type' => 'application/json'],
                    'body' => [
                        'room_id'       =>  $room->id,
                        'start_date'    =>  $params['start_date'],
                        'end_date'      =>  $params['end_date'],
                        'total_price'   =>  $params['total'],
                        'total_night'   =>  $params['days'],
                        'first_name'    =>  $firstname,
                        'last_name'     =>  $lastname,
                        'phone'         =>  $phone,
                        'email'         =>  $email
                    ]
                ]);

                if ( is_wp_error( $response ) ) {
                    $error_message = $response->get_error_message();
                    var_dump($error_message);die;
                }else{
                    echo 'Response:<pre>';
                    print_r( $response );
                    echo '</pre>';
                    die;
                }                

            }
        }
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

            <form action="<?php echo $_SERVER['PHP_SELF']."/rooms" ?>" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name">First name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="" required="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name">Last name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name" value="" required="">
                    </div>
                </div> 
                <div class="mb-3">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone number" required="">
                </div> 
                <div class="mb-3">
                    <label for="address">Email Address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required="">
                </div>
                <div class="g-recaptcha" data-sitekey=""></div>
                <hr class="mb-4">

                <input name="start_date" class="form-control" type="hidden" value="<?php echo $params['start_date'] ?>">
                <input name="end_date" class="form-control" type="hidden" value="<?php echo $params['end_date'] ?>">
                <input name="room_type" class="form-control" type="hidden" value="<?php echo $params['room_type'] ?>">
                <input name="rooms" class="form-control" type="hidden" value="<?php echo $room->id ?>">

                <button class="btn btn-danger btn-block" type="submit">Confirm Booking</button>
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