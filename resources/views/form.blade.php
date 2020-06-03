<div class="subscribe">
    <form id="provider">
        <h2><span id="displayName"></span> <span class="ion-ios-close float-right" id="close"></span></h2>

        <div class="row">

            <div class="col-12 col-md-6 col-lg-6">
                <i class="ion-ios-apps"></i>
                <select name="provider" class="custom-select" id="bouquets">
                    <option value="" selected disabled>Bouquets</option>
                </select>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <i class="ion-ios-apps"></i>
                <select name="provider" class="custom-select" id="duration">
                    <option value="" >Duration</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6  col-lg-6 ">
                <i class="ion-ios-cash"></i> <input type="text" name="costs" placeholder="Amount" id="amount" readonly/>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <i class="ion-ios-card"></i> <input type="text" name="smartcard" placeholder="Smartcard"/>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <button type="button" name="continue" style="background: #09f" disabled="disabled">Continue</button>
            </div>
        </div>

    </form>

    <form id="billings">
        <h2>Pay for <b data-provider="provider">DSTV</b> <span class="ion-ios-arrow-back float-right" id="back"></span></h2>

        <h4>Verify Information</h4>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <i class="ion-ios-card"></i> <input type="text" name="full_name" readonly placeholder="Fullname"/>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6  col-lg-6 ">
                <i class="ion-ios-person"></i> <input type="text" name="smartcard" readonly placeholder="Smart Card"/>
            </div>

            <div class="col-12 col-md-6  col-lg-6 ">
                <i class="ion-ios-mail"></i> <input type="text" name="bouquet" readonly placeholder="Bouquet"/>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6  col-lg-6 ">
                <i class="ion-ios-call"></i> <input type="text" name="duration" readonly placeholder="Duration"/>
            </div>

            <div class="col-12 col-md-6  col-lg-6 ">
                <i class="ion-ios-code"></i> <input type="text" name="amount" readonly placeholder="Amount"/>
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
        <p>Holla!, Your Subscription for <span></span> was successful!</p>
        <a href="javascript:location.reload()">Continue</a>
    </form>
</div>
