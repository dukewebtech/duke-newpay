function payWithPaystack($mail,$cash, $curr, respdata )
{
var pk_live = 'pk_live_8ebb4cb0184238555523e9f6c307a0';
	pk_live+= '2402cd49bc';

var sk_live = 'sk_live_0bc959087757d6688c63bbe2e835cb';
	sk_live+= '2690637c7a';
	
var pk_test = 'pk_test_e698f0bfffe1147ed0dd616fdc2813';
	pk_test+= 'c8c2e2a8f4';

var sk_test = 'sk_test_ab1f34c00fe9cba49d53b8387af3b1';
	sk_test+= '4e62435cec';

var handler = PaystackPop.setup (					  {
	key   :  (pk_live	) ,
	email :  ($mail  	) ,
	amount:  ($cash  	) ,
	currency:($curr !=  undefined) ? ($curr) : ('NGN'),
	ref: Math.floor((Math.random() * 1000000000) + (1))
	,
	metadata:     		{
	/*
    custom_fields:		[							  {
	display_name : "phone_number",//custom "POST" field
	variable_name: "phone_number",//custom "POST" field
    }]
	*/
    },
	//TODO: Callback Events to process when successful!
    callback: respdata, //attempt to pass to a callback
	///////////////////////////////////////////////////
		
	//TODO: Callback Events to process when form closed
    onClose : function  (e)							  {
	/*
	You can as well write your own custom  Javascript / 
	JQuery Command here incase the user  clicked Cancel 
	on the Payment form / popup form. it so important!.
	
	E.g
	$('div.pop-up').stop(true).fadeOut('slow','linear')
	*/
	$('.sleek-cover * div.loader').fadeOut     ('slow')
	}

	
    });
    handler.openIframe  (		 )					  ;
}