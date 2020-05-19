<div class="subscribe">
    <form id="provider">
        <h2>Pay for <b data-provider="provider">DSTV </b> <span class="ion-ios-close float-right" id="close"></span></h2>

        <h4>Subscriptibvon Plan</h4>
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <i class="ion-ios-tv"></i>
                <select name="provider" class="custom-select">
                    <option value="" selected disabled>Provider</option>
                    @foreach($serviceTypes as $serviceType)

                        <option value="{{$serviceType}}">{{$serviceType}}</option>
                        @endforeach
                </select>
            </div>
        </div>

        <div class="row">
{{--            <div class="col-12 col-md-6  col-lg-6 ">--}}
{{--                <i class="ion-ios-apps"></i>--}}

{{--                <select  class="custom-select">--}}
{{--                    <option value="" selected disabled>Bouqets</option>--}}
{{--                </select>--}}
{{--                @foreach($bouquets["data"] as $bouquet)--}}
{{--                <option value="">{{$bouquet["name"]}}</option>--}}
{{--                @endforeach--}}
{{--            </div>--}}


                <div class="col-12 col-md-6 col-lg-6">
                    <i class="ion-ios-apps"></i>
                    <select name="provider" class="custom-select">
                        <option value="" selected disabled>Bouqets</option>
                        @foreach($bouquets["data"] as $bouquet)

                            <option value="{{$bouquet["name"]}}">{{$bouquet["name"]}}</option>
                        @endforeach
                    </select>
                </div>
            <div class="col-12 col-md-6 col-lg-6">
                <i class="ion-ios-apps"></i>
                <select name="provider" class="custom-select">
                    <option value="" selected disabled>Bouqets</option>
                    @foreach($bouquets["data"] as $bouquet)
                            @foreach ($bouquet["availablePricingOptions"] as $months)
                        <option value="{{$months["monthsPaidFor"]}}">{{$months["monthsPaidFor"]}}</option>
                                @endforeach
                    @endforeach
                </select>
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
                <i class="ion-ios-code"></i> <input type="text" name="reference" readonly placeholder="Reference" value=""/>
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
