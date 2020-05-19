<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BaxiPay</title>

    <link rel="shortcut icon" href="images/favicon.png"/>

    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/ion-icon.min.css" />
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="stylesheet" href="css/app.css"/>

    <script src="js/jquery.js"> </script>
    <script src="js/app.js"> </script>
</head>

<body>
<section class="App">
    <header>
        <img src="images/favicon.png" width="80" height="50" alt=""/> <span><b>Baxi</b>Pay</span>
    </header>

    <div class="container">
        <div class="splash">
            <h2>Welcome to <b>Baxi</b>Pay <span><button class="active">Login</button> <button class=>Sign Up</button></span></h2>
            <p>Pay for TV, Utility and Internet Bills & Subscriptions right from the confort of your home. anywhere, anytime!</p>

            <div class="row" id="service-splash">

                @foreach($serviceTypes as $serviceType)
                <div class="col-md-4 col-lg-4">
                        <div class="card" style="color: rgb(255, 255, 255); background: rgb(238, 204, 17); display: flex;" data-provider="" data-service="">


                        <i class="fa fa-tv"></i>
                       <span>{{$serviceType}}</span>

                    </div>
                </div>
                @endforeach


            </div>
        </div>
    </div>
@include('form');

</section>
</body>
</html>
