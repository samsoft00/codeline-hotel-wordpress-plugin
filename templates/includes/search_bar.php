<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron" style="padding-top:80px">
    <div class="container">
        <h1 class="display-3">Search Available Rooms</h1>
        <hr/>
        <form action="<?php echo $_SERVER['PHP_SELF']."/rooms" ?>" method="GET">
            <input name="rooms" class="form-control" type="hidden" value="">
            <div class="row">
                <div class="col-md-5 mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" placeholder="" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" name="end_date" id="end_date" placeholder="" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="room_type">Room Type</label>
                    <select class="custom-select d-block w-100" id="room_type" name="room_type" required>
                        <option selected disabled>Choose type</option>
                        <?php foreach ($roomType as $type ) { ?>
                            <option value=<?php echo $type->id ?> ><?php echo $type->type ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>  
            <button type="submit" class="btn btn-success btn-lg" href="#" role="button">Search rooms &raquo;</button>                  
        </form>
    </div>
</div>