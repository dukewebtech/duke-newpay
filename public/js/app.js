$(document).ready(function(e) {

    //1: Provider Effects
    $('.App .splash .card').stop(true).hide(0);
    let i = 1;
    $('.App .splash .card').each( (i, e)  =>  {
        setInterval(() => { $(e).fadeIn('slow', 'linear') },  ( i * 500 ) );
        i++;
    });
    if(i == $('.App .splash .card').length)   {
        $('.App .splash  div.card').css('transition', '0.5s ease-in-out')  ;
    }

    //2: Provider Request
    let subscription = {};
    $('.App .splash .card').click(function() {
        let serviceType = $.trim($(this).data('service-type'));
        let displayName = $.trim($(this).data('display-name'));

        $('.App .subscribe').stop(true).addClass('show') ;
        $('.App .subscribe form#provider [data-provider]').text(displayName);
        $('form#provider [name=provider]').val("providerId");

        $('form#provider button[name="continue"]').attr('disabled', 'disabled')

        $("#displayName").text(displayName);

        return bouquetsProvider(serviceType);
    });

    // $('#billers').change(function() {
        // let providerId = $.trim($(this).val());
        // let serviceTag = $.trim($('[name=provider] option:selected').text());
        // $('.App .subscribe form#provider [data-provider]').text (serviceTag);
        //
        // return bouquetsProvider(providerId);
    // });

    const bouquetsProvider = (serviceType)  => {
        subscription = {};

        let url = "/service-types/" + serviceType + "/bouquets";
        $.ajax({
            type: "GET",
            url: url,
            success: function(response) {
                let $bouquets = $("#bouquets");
                $bouquets.find('option').remove(); // clears the list
                $bouquets.append(new Option("Select", "", true));
                $.each(response.data, function (index, bouquet) {

                    let option = $("<option>")
                        .val(bouquet.code)
                        .text(bouquet.name)
                        .attr("data-price-options", JSON.stringify(bouquet.availablePricingOptions));

                    $bouquets.append(option);
                });
            }
        });
        subscription['serviceType'] = serviceType;
    };

    //3: Bouqet Requests
    $("#bouquets").change(function() {
        let priceOptions = $(this).find(':selected').data("price-options");
        let $duration = $("#duration");
        $duration.find('option').remove(); // clears the list
        $duration.append(new Option("Select", "", true));

        $.each(priceOptions, function (index, priceOption) {
            let month = priceOption.monthsPaidFor === 1 ? " Month " : " Months ";
            let text = priceOption.monthsPaidFor + month + "(" + addCommas(priceOption.price) + ")";
            let option = $("<option />")
                .val(priceOption.monthsPaidFor)
                .text(text)
                .attr("data-amount", priceOption.price)
                .attr("data-period", priceOption.monthsPaidFor);

            $duration.append(option);
        });

        subscription['bouquet'] = $(this).val().trim(   );
        subscription['package'] = $(this).find(':selected').text()
    });

    //4: Package Selection
    $("#duration").change(function () {
        let amount = $(this).find(':selected').data("amount");
        let period = $(this).find(':selected').data("period");

        $("#amount").val(amount); // set the amount on the view / field

        subscription['amount'] = amount;
        subscription['period'] = period;
    });

    // $('form#provider [name=package]' ).on('change, input', function(e)     {
    //     let month = $('[name=package] option:selected').data ('month');
    //     let costs = $('[name=package] option:selected').data ('costs');
    //
    //     $('[name=month').val(' '+month);
    //     $('[name=costs').val('N'+costs);
    //
    //     subscription['package'] = $(this).val().trim(   );
    // });

    //5: Smartcard Checker
    let checkSmartCard = true;
    $('form#provider [name=smartcard]').on('keyup, input', function(e)     {
        let smartCard = $.trim($('form#provider [name=smartcard]').val());

        if(/^\d+$/.test(smartCard) ==0) { $(this).val('') } //reset the form if error
        subscription['customer'] = null;
        $('form#provider button[name="continue"]')
            .attr('disabled', 'disabled')
            .text('Continue')

        if(checkSmartCard && smartCard.length == 10) {
            $('form#provider button[name="continue"]').text('Loading...'); //preload

            $.ajax({
            type: "POST",
            url: `/api/verify/${smartCard}/${subscription['serviceType']}`,
            success: function(response){
                response = JSON.parse(response.trim( ))

                if(response != "" && response['data']['user']['name']   !=  undefined)    {
                    subscription['smartcard'] = smartCard;
                    subscription['customer'] = response;

                    $('form#provider button[name="continue"]').removeAttr('disabled')    ;
                    $('form#provider button[name="continue"]').text('Continue')    ;
                }
            }
        });
        }
    })

    //6: Continue Controls
    $('form#provider button[name="continue"]').on('click', function(e)     {

        if(subscription['bouquet']   == undefined){
            return alert("You haven't selected any Bouquet!");
        }
        if(subscription['period' ]  == undefined){
            return alert("You havent't selected any Package");
        }
        if(subscription['customer'] == undefined){
            return alert("The smartcard number is invalid! ");
        }
        $('form#provider').addClass   ('hide');
        $('form#billings').addClass   ('show');

        const customer = subscription['customer']['data']['user']['name'];

        $('form#billings [name=full_name]').val(customer)
        $('form#billings [name=smartcard]').val(subscription['smartcard']);
        $('form#billings [name=bouquet]').val(subscription['package']);
        $('form#billings [name=duration]').val(subscription['period']+' month\'s');
        $('form#billings [name=amount]').val('NGN'+subscription['amount']);
    });

    //7: Purchase Controls
    let ref = "";
    $('form#billings button[name="purchase"]').on('click', function(e)     {
        subscription['agentId'] = 105;
        subscription['reference'] = Math.floor(Math.random()*90000)+(1000000000) ;

        let amount = subscription['amount'];
        let monthsPaidFor = subscription['period'];
        let product = subscription['bouquet'];
        let smartCard = subscription['smartcard'];
        let reference = subscription['reference'];
        let agentId = subscription['agentId'];
        let serviceType = subscription['serviceType'];

        // if(smartCard == ''){ return alert("Please enter smartcard number");
        // }
        // if(monthsPaidFor == ''){  return alert("Please enter your fullname");
        // }
        // if(email     == ''){  return alert("Please enter your Email Addr");
        // }
        let data = {
            'subscription' : subscription
        };
        // $.ajax({
        //     type: "POST",
        //     data: (data),
        //     url: "?api/baxi/pay",
        //     success: function(response){
        //         response=JSON.parse(response.trim(  ))
        //
        //         if(response=='success'){
        //             $('form#billings').addClass   ('hide');
        //             $('form#verified').addClass   ('show');
        //
        //             let bouqet = $('[name="bouqets"] option:selected').text()
        //             $('form#verified p span').text(bouqet);
        //         }
        //         if(response=='failure'){
        //             alert("Fail to pay for Subscription!, Try again later!");
        //             window.location = location.reload()
        //         }
        //     }
        // });

        const fakeUser = Math.floor(Math.random()*90000)+(10000) ;

        amount = ((subscription['amount']) * 100)
        payWithPaystack(fakeUser+'@dukepay.com.ng', amount , 'NGN', function(r){
            ref = r.reference;
            $.ajax({
                url: 'api/paystack/verify/'+ref,
                type:'POST',
                contentType:false,
                success: function 	  (response, status)     {
                    response = JSON.parse (response)

                    if(response['status'] == 'success' )     {
                        return paySubscription(subscription) ;
                    }
                    if(response['status'] == 'failure' )     {
                        alert("Fail to pay for subscription!, Try again later!")
                        location.reload()
                    }
                }
            });
        });
    });

    const paySubscription = (subscription) => {
        let data = {
            "subscription" : JSON.stringify(subscription)
        }
        $.ajax({
            url: 'api/pay/subscription',
            type:'POST',
            data: data,
            success: function 	  (response, status)     {
                response = JSON.parse (response)

                //do some visual callback to the end user!
            }
        });
    }

    //8: Finalized Button
    $('.App .subscribe h2 span#close').on('click' , (e)=>{
        $('.App .subscribe').stop(true).removeClass('show')

        setTimeout(() => {
        location.reload()
        }, 500);
    });

    $('.App .subscribe h2 span#back ').on('click' , (e)=>{
        $('form#provider').removeClass('hide'); /////////////////////////////
        $('form#billings').removeClass('show'); /////////////////////////////
    });

    const build = (getModel, ...getParameter) =>     {
        var model = $.trim($(getModel).html()        )  ;

        for(let x in getParameter)   {
            for(let n of Object.keys (getParameter[x])  )
            {
                if(getParameter[x][n]  ==  (undefined)  )                  {
                    getParameter[x][n] = $('[name='+n+']').val( ).trim (  );
                }
                model = model.replace(RegExp(':'+n,'g'),getParameter[x][n]);
            }
            return(model) //returning a dynamic components to the view model
        }
    };
    /////////////////////////////////////////////////////////////////////////
});


function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
