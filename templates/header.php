<?php 

    $requests = wp_remote_get(CL_BASE_API_URL.'/room-type');
    if( is_wp_error( $request ) ) {
        die('Unable to access remote resources');
    }

    $roomType = json_decode( $requests ['body'] );

    $rooms = [];

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
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <title>Codeline Hotel</title>
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