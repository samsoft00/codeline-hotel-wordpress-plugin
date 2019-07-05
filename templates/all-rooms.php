<?php 
    //include external header
    include_once('header.php');

    // require_once( 'wp-load.php' );

    // //get list of available rooms
    // $requests = wp_remote_get(CL_BASE_API_URL.'/rooms');

    // if( is_wp_error( $request ) ) {
    //     die('Unable to access remote resources');
    // }

    // $rooms = json_decode( $requests ['body'] );
    $IMAGE_PATH = CL_BASE_IMAGE_URL;
?>


<div class="container">

    <h1>Available Rooms</h1>
    <hr/>
    <div class="row">

        <?php

            if(! empty($rooms) || !is_null($rooms) ){

                foreach ($rooms as $room) {
                    # code...
                    ?>

                    <div class="col-lg-4 col-md-6" style="margin-bottom:30px;">
                        <div class="card">
                            
                            <img src=<?php echo $IMAGE_PATH.$room->image ?> class="card-img-top" alt="" style="height:150px">
                            <div class="card-body">
                            <div class="badge badge-danger details_sub" style="font-size:inherit"><?php echo "$".$room->type->cost->price; ?> / Night</div><br/>
                                <h5 class="card-title" style="margin-bottom:0px"> <?php echo "Room ".$room->name ?></h5>
                                <div class="card-text" style="margin-bottom:10px">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Start Date</th>
                                        <td><?php echo $queryParams['start_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td><?php echo $queryParams['end_date'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Days</th>
                                        <td><?php echo $numberOfDays." Days" ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Cost</th>
                                        <td><?php echo "$".$room->type->cost->price * $numberOfDays ?></td>
                                    </tr>                                                                                   
                                </table>                                
                                </div>
                                <button tag="button" class="btn btn-primary btn-block" >More Info</button>
                            </div>            
                            
                        </div>
                    </div>                        

                    <?php
                }                

            }else {

                echo "<h2>Rooms not available<h2/>";

            }
        ?>
    </div>
</div>

<?php include_once('footer.php'); ?>