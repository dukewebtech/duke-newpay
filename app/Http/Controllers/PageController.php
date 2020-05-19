<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaxiService;
class PageController extends Controller
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
    public function allBouquets()
    {

    }
    public function index()
    {
        $serviceTypes = ['DSTV','GOTV','STARTIMES'];



        return view('index',compact('serviceTypes'));



    }

    public function showBouquets(string $serviceType)
    {
        try {
            return $this->baxiService->retrieveProviderBouquets($serviceType);
        } catch (\Exception $e) {
            // Do something

        }
    }
}
