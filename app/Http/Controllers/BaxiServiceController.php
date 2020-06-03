<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaxiService;

class BaxiServiceController extends Controller
{
    /**
     * @var BaxiService
     */
    private $baxiService;

    /**
     * BaxiController constructor.
     * @param BaxiService $baxiService
     */
    public function __construct(BaxiService $baxiService)
    {
        $this->baxiService = $baxiService;
    }

    public function accountBalance()
    {
        return $this->baxiService->checkAccountBalance();
    }

    public function retrieveProviderBouquets()
    {
        $serviceType = "dstv";
        $mydata1 = $this->baxiService->retrieveProviderBouquets($serviceType);
        $mydata= json_decode($mydata1, false);
    //    return $mydata;
        // return $mydata1;
        return view('index',compact('mydata'));

    }
    public function retrieveDstvBouquets()
    {
        $serviceType = "dstv";
        $mydata1 = $this->baxiService->retrieveProviderBouquets($serviceType);
        $mydata= json_decode($mydata1, true);
    //    return $mydata;
    //    return $mydata1;
        return view('/test',compact('mydata'));

    }
    public function retrieveGotvBouquets()
    {
        $serviceType = "dstv";
        $mydata1 = $this->baxiService->retrieveProviderBouquets($serviceType);
        $mydata= json_decode($mydata1, false);
    //    return $mydata;
    //    return $mydata1;
        return view('biller.packageDetails',compact('mydata'));

    }
    public function retrieveallBouquets($serviceType)
    {
        $serviceTypes = request('servicetype');
        $mydata1 = $this->baxiService->retrieveProviderBouquets($serviceTypes);
        $mydata= json_decode($mydata1, true);
    //    return $mydata;
    //    return $mydata1;
        return view('/mydata',compact('mydata','serviceTypes'));

    }
// public function retrieveallBouquets($servicetype)
//     {
//         $serviceTypes = request('servicetype');
//         $mydata1 = $this->baxiService->retrieveProviderBouquets($serviceTypes);
//         $mydata= json_decode($mydata1, true);
//     //    return $mydata;
//     //    return $mydata1;
//         return view('/test',compact('mydata'));

//     }



    public function retrieveProviderAddons($serviceType,$productCode)
    {
        $serviceType = request('serviceType');
        $productCode = request('productCode');
        $productName = "DStv Access";
        $mydata1 = $this->baxiService->retrieveProviderAddons($serviceType,$productCode);
        $mydata = json_decode($mydata1, true);
        // return $mydata;
        return view('biller.packageDetails',compact('mydata','productName'));
    }

    public function verifyAccount($accountNumber,$serviceType){
        $accountNumber = request('accountNumber');
        $serviceType = request('serviceType');

        $results = $this->baxiService->verifyAccount($accountNumber,$serviceType);
        return $results;
    }

    public function verifyTransaction(int $reference) : string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.paystack.co/transaction/verify/'.$reference  ) ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER	   , [
            'Authorization: Bearer sk_test_956229a549193b1466c4d1dcfc91249be5fbca39'
        ]);
        $request = curl_exec($ch);
        curl_close			($ch);

        if ($request) {
            $result = json_decode($request,  true); ///////////////////////////////////////////////
            if ($result['data']['status'] == 'success'){
                session(['reference' => $reference]);
                $status = 'success';   //returns a success callback to ajax controller for clausing
            }
            else{
                $status = 'failure';   //returns a failure callback to ajax controller for clausing
            }
        }
        else{
            if(!$result){
                $status = 'failure';   //returns a failure callback to ajax controller for clausing
            }
        }
        return json_encode(['status' => $status]);
    }

    public function paySubscription(){
        $subscription = request('subscription');

        $results = $this->baxiService->paySubscription($subscription);
        return $results;
    }
}
