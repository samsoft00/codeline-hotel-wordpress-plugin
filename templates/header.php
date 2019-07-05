<?php 

    $requests = wp_remote_get(CL_BASE_API_URL.'/room-type');
    if( is_wp_error( $request ) ) {
        die('Unable to access remote resources');
    }

    $roomType = json_decode( $requests ['body'] );

    if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date']) && isset($_REQUEST['room_type'])){
        //search begins
        //room/search?type=${this.search.type}&start_date=${this.search.start_date}&end_date=${this.search.end_date}`

        $start_date     = date_create($_REQUEST['start_date']);
        $end_date       = date_create($_REQUEST['end_date']);
        $dayDiff        = date_diff($end_date, $start_date);

        $queryParams = [
            'type'          =>  $_REQUEST['room_type'],
            'start_date'    =>  date_format($start_date,"d-m-Y"),
            'end_date'      =>  date_format($end_date,"d-m-Y")
        ];
        
        $search_requests = wp_remote_get(CL_BASE_API_URL.'/rooms/search?'.http_build_query($queryParams));
        $rooms = json_decode( $search_requests['body'] );
        $numberOfDays = $dayDiff->days;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Codeline Hotel</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">

            </ul>

        </div>
  </div>
</nav>
    <style>
        .table td, .table th {
            padding: .30rem;
        }    
    </style>
    <main role="main">

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