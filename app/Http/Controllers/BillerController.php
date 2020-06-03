<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BaxiService;
class BillerController extends Controller
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
        $billers = [
            [
                "serviceType" => "dstv",
                "displayName" => "DSTV Subscription",
                "logo" => "",
                "style_color" => "color: #09f; background: #fff"
            ],
            [
                "serviceType" => "gotv",
                "displayName" => "GOTV Subscription",
                "logo" => "",
                "style_color" => "color: #fff; background: #ec1"
            ],
            [
                "serviceType" => "startimes",
                "displayName" => "STARTIMES Subscription",
                "logo" => "",
                "style_color" => "color: #fff; background: #09f"
            ]
        ];

        return view('index', compact('billers'));
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
