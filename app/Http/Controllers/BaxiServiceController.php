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

}
