function payWithPaystack($mail,$cash, $curr, respdata )
{
var pk_live = 'pk_live_1cf293ae83aba80f9ccf90f9c96c96';
	pk_live+= 'b59ebcb4b2';

var sk_live = 'sk_live_67923aa506ab7a94e6025d16eaec4b';
	sk_live+= '51cbc2d997';

var pk_test = 'pk_test_01516c7ea0504bcebe167cca6585d3';
	pk_test+= '44a6a6ef6a';

var sk_test = 'sk_test_956229a549193b1466c4d1dcfc9124';
	sk_test+= '9be5fbca39';

var handler = PaystackPop.setup (					  {
	key   :  (pk_test	) ,
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

	$('.sleek-cover * div.loader').fadeOut     ('slow')
	 */
	}

    });
    handler.openIframe  (		 )					  ;
}
