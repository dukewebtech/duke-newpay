<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// class BaxiService extends Model
// {
//     //
// }
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class BaxiService
{
    /**
     * @var BaxiClient
     */
    private $baxiClient;

    /**
     * BaxiService constructor.
     * @param BaxiClient $baxiClient
     */
    public function __construct(BaxiClient $baxiClient)
    {
        $this->baxiClient = $baxiClient;
    }

    public function checkAccountBalance() : String
    {
        try {
            $response = $this->baxiClient->call("GET", "/superagent/account/balance", null);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return ($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string $serviceType
     * @return array
     * @throws Exception
     */
    public function retrieveProviderBouquets(string $serviceType) : array
    {
        $validServiceTypes = ["dstv", "gotv", "startimes"];

        if (!in_array($serviceType, $validServiceTypes))
            throw new Exception("Invalid Service Type");

        try {
            $response = $this->baxiClient->call("POST", "/services/multichoice/list", [
                "service_type" => $serviceType
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
     /**
     * @param string $serviceType
     * @param string $productCode
     * @return string
     * @throws Exception
     */
    public function retrieveProviderAddons(string $serviceType,$productCode) : string
    {
        $validServiceTypes = ["dstv", "gotv", "startimes"];

        if (!in_array($serviceType, $validServiceTypes))
            throw new Exception("Invalid Service Type");

        try {
            $response = $this->baxiClient->call("POST", "/services/multichoice/addons", [
                "service_type" => $serviceType,
                "product_code" => $productCode
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return ($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function verifyAccount(string $accountNumber,$serviceType) : string
    {
        $validServiceTypes = ["dstv", "gotv", "startimes"];

        if (!in_array($serviceType, $validServiceTypes))
            throw new Exception("Invalid Service Type");

        try {
            $response = $this->baxiClient->call("POST", "/services/namefinder/query", [
                "service_type" => $serviceType,
                "account_number" => $accountNumber
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return ($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function paySubscription($subscription)
    {
        $subscription = json_decode($subscription, true);

//        $validServiceTypes = ["dstv", "gotv", "startimes"];
//
//        if (!in_array($serviceType, $validServiceTypes))
//            throw new Exception("Invalid Service Type");

        try {
            $response = $this->baxiClient->call("POST", "/services/multichoice/request", [
                "service_type" => $subscription['serviceType'],
                "total_amount" =>  $subscription['amount'],
                "product_monthsPaidFor" =>  $subscription['period'],
                "product_code" =>  $subscription['bouquet'],
                "smartcard_number" =>  $subscription['smartcard'],
                "agentReference" => $subscription['reference'],
                "agentId" =>  $subscription['agentId']
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return ($e->getResponse()->getBody()->getContents());
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
