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

        $("#displayName").text(displayName);

        return bouquetsProvider(serviceType);
    });

    $('#billers').change(function() {
        let providerId = $.trim($(this).val());
        let serviceTag = $.trim($('[name=provider] option:selected').text());
        $('.App .subscribe form#provider [data-provider]').text (serviceTag);

        return bouquetsProvider(providerId);
    });

    const bouquetsProvider = (serviceType)  => {

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
                .attr("data-amount", priceOption.price);

            $duration.append(option);
        });
    });

    $("#duration").change(function () {
        $("#amount").val($(this).find(':selected').data("amount"));
    });

    $('form#provider [name=package]' ).on('change, input', function(e)     {
        let month = $('[name=package] option:selected').data ('month');
        let costs = $('[name=package] option:selected').data ('costs');

        $('[name=month').val(' '+month);
        $('[name=costs').val('N'+costs);

        subscription['package'] = $(this).val().trim(   );

    });

    //4: Continue Controls
    $('form#provider button[name="continue"]').on('click', function(e)     {

        // if(subscription['bouquet']   == undefined){
        //     return alert("You haven't selected any Bouqet  ");
        // }
        // if(subscription['package']  == undefined){
        //     return alert("You havent't selected any Package");
        // }
        $('form#provider').addClass   ('hide');
        $('form#billings').addClass   ('show');
    });

    //5: Purchase Controls
    let checkSmartCard = true;
    $('form#billings [name=smartcard]').on('keyup, input', function(e)     {
        let smartCard = $.trim($('form#billings [name=smartcard]').val());

        $('form#billings [name=full_name]').val ('') ;
        $('form#billings [name=email]').val ('')
        $('form#billings [name=telephone]').val ('') ;

        if(checkSmartCard && smartCard.length == 10) {
        let data = {
            'smartcard' : smartCard
        };
        $.ajax({
            type: "POST",
            data: (data),
            url: "?api/baxi/biller",
            success: function(response){
                response=JSON.parse(response.trim(  ))

                if(response){
                    $('form [name=full_name]').val(response['full_name']);
                    $('form [name=email]').val(response['email'])
                    $('form [name=telephone]').val(response['telephone']);
                }
            }
        });
        }
    })
    
    $('form#billings button[name="purchase"]').on('click', function(e)     {
        let smartCard = $.trim($('form#billings [name=smartcard]').val());
        let full_name = $.trim($('form#billings [name=full_name]').val());
        let email = $.trim($('form#billings [name=email]').val());
        let telephone = $.trim($('form#billings [name=telephone]').val());
        let reference = $.trim($('form#billings [name=reference]').val());

        if(smartCard == ''){ return alert("Please enter smartcard number");
        }
        if(full_name == ''){  return alert("Please enter your fullname  ");
        }
        if(email     == ''){  return alert("Please enter your Email Addr"); 
        }
        let data = {
            'subscription' : subscription,
            'billerDetail' : {
                'smartcard' : smartCard,
                'full_name' : full_name,
                'email' : email,
                'telephone' : telephone,
                'reference' : reference
            }
        };
        $.ajax({
            type: "POST",
            data: (data),
            url: "?api/baxi/pay",
            success: function(response){
                response=JSON.parse(response.trim(  ))

                if(response=='success'){
                    $('form#billings').addClass   ('hide');
                    $('form#verified').addClass   ('show');

                    let bouqet = $('[name="bouqets"] option:selected').text()
                    $('form#verified p span').text(bouqet);
                }
                if(response=='failure'){
                    alert("Fail to pay for Subscription!, Try again later!");
                    window.location = location.reload()
                }
            }
        });
    });

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