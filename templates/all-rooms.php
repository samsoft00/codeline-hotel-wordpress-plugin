<?php 
    //include external header
    include_once('header.php');

    include_once('includes/search_bar.php');
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

                                <form method="GET">
                                    <input name="start_date" class="form-control" type="hidden" value="<?php echo $queryParams['start_date'] ?>">
                                    <input name="end_date" class="form-control" type="hidden" value="<?php echo $queryParams['end_date'] ?>">
                                    <input name="room_type" class="form-control" type="hidden" value="<?php echo $queryParams['type'] ?>">
                                    <input name="rooms" class="form-control" type="hidden" value="<?php echo $room->id ?>">
                                    <button tag="button" type="submit" class="btn btn-danger btn-block" >Book Now</button>
                                </form>
                                
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