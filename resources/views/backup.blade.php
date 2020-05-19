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
                <div class="col-md-4 col-lg-4">
                    <div class="card" style="color: rgb(255, 255, 255); background: rgb(238, 204, 17); display: flex;" data-provider="2" data-service="DSTV">
                        <i class="fa fa-tv"></i>
                        <span>DSTV</span>
                        <p>Subscribe for DSTV Bills and your favourite Bouqet Channels</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="subscribe">
        <form id="provider">
            <h2>Pay for <b data-provider="provider">DSTV</b> <span class="ion-ios-close float-right" id="close"></span></h2>

            <h4>Subscription Plan</h4>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <i class="ion-ios-tv"></i>
                    <select name="provider" class="custom-select">
                        <option value="" selected disabled>Provider</option>


                        <option value="">Go tv Plus</option>D
                        <option value="">Go tv Plus</option>D
                        <option value="">Go tv Plus</option>D


                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-apps"></i>
                    <select name="bouqets" class="custom-select">
                        <option value="" selected disabled>Bouqets</option>
                    </select>

                    <div class="d-none" id="bouqetModel"><option value=":id">:bouquet</option></div>
                </div>

                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-infinite"></i>
                    <select name="package" class="custom-select">
                        <option value="" selected disabled>Packages</option>
                    </select>

                    <div class="d-none" id="packageModel"><option value=":id" data-month=":month" data-costs=":charges">:package</option></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-calendar"></i> <input type="text" name="month" placeholder="Month's" readonly/>
                </div>

                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-cash"></i> <input type="text" name="costs" placeholder="Amount" readonly/>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <button type="button" name="continue" style="background: #09f">Continue</button>
                </div>
            </div>
        </form>

        <form id="billings">
            <h2>Pay for <b data-provider="provider">DSTV</b> <span class="ion-ios-arrow-back float-right" id="back"></span></h2>

            <h4>Billing Information</h4>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <i class="ion-ios-card"></i> <input type="text" name="smartcard" placeholder="Smartcard"/>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-person"></i> <input type="text" name="full_name" placeholder="Fullname"/>
                </div>

                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-mail"></i> <input type="text" name="email" placeholder="E-mail"/>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-call"></i> <input type="text" name="telephone" placeholder="Telephone"/>
                </div>

                <div class="col-12 col-md-6  col-lg-6 ">
                    <i class="ion-ios-code"></i> <input type="text" name="reference" readonly placeholder="Reference" value="57585"/>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <button type="button" name="purchase" style="background: #090">Pay Now</button>
                </div>
            </div>
        </form>

        <form id="verified">
            <h2>Payment <b data-provider="provider">Successful!</b> <span class="ion-ios-close float-right" id="close"></span></h2>
            <i class="ion-ios-checkmark-circle"></i>
            <p>Holla!, Your Subscription for <span>d</span> was successful!</p>
            <a href="javascript:location.reload()">Continue</a>
        </form>
    </div>
</section>
</body>
</html>
