<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
class BaxiClient
{
    /**
     * @var string
     */
    const USERNAME = "baxi_test";

    /**
     * @var string
     */
    const USER_SECRET = "5xjqQ7MafFJ5XBTN";

    /**
     * @var string
     */
    const BASE_URL = "https://payments.baxipay.com.ng/api/baxipay";

    /**
     * @var string
     */
    const BEARER = "Baxi";

    const API_KEY = "5adea9-044a85-708016-7ae662-646d59";
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var bool
     */
    private $apiKeyAuthEnabled = true;

    /**
     * @param string $httpMethod
     * @param string $uri
     * @param array $requestPayload
     * @return mixed|ResponseInterface
     * @throws GuzzleException
     * @throws Exception
     */
    public function call(string $httpMethod, string $uri, ?array $requestPayload): ResponseInterface
    {
        $httpMethod = strtoupper($httpMethod);
        if ($httpMethod !== "GET" && $httpMethod !== "POST")
            throw new Exception("HTTP Method not allowed.");

        $this->makeHeader($httpMethod, $uri, $requestPayload);

        $options["headers"] = $this->headers;
        if (!empty($requestPayload)) $options['json'] = $requestPayload;

        $client = new Client();
        return $client->request($httpMethod, self::BASE_URL . $uri, $options);
    }

    /**
     * @param string $httpMethod
     * @param string $endpoint
     * @param array|null $requestPayload
     */
    private function makeHeader(string $httpMethod, string $endpoint, ?array $requestPayload): void
    {
        $requestDate = Carbon::now('GMT');

        if ($this->apiKeyAuthEnabled) {
            $this->headers = [
                "x-api-key" => self::API_KEY
            ];
        } else {
            $signature = $this->makeSignature($httpMethod, $endpoint, $requestDate->timestamp, $requestPayload);
            $this->headers = [
                "Authorization" => self::BEARER . " " . self::USERNAME . ":" . $signature,
                "baxi-date" => $requestDate->format("D, d M Y H:i:s T")
            ];
        }
        $this->headers["Accept"] = "application/json";
        $this->headers["Content-Type"] = "application/json";

    }

    /*
     * How To Calculate Baxi HMAC Digest Signature
     * 1. Request Type: ("GET" or "POST")
     * 2. End point  to access: /api/baxipay/superagent/account/balance
     * 3. Request Date in RFC 1123 format: Thu, 19 Dec 2019 17:40:26 GMT
     * 4. Json Payload (if available):   { "name":"tayo" }
     * 5. Your User Secret: "YOUR_USER_SECRET"
    */
    private function makeSignature(string $httpMethod, string $endpoint, int $timestamp, ?array $requestPayload): string
    {
        $encodedPayload = "";

        if (!empty($requestPayload)) {
            // STEP 2: Do a SHA-256 Hash of your JSON Payload in (4) above. (if applicable)
            $payloadHash = hash("sha256", json_encode($requestPayload), true);

            // STEP 3: Encode the Payload_Hash in Base 64 (if applicable)
            $encodedPayload = base64_encode($payloadHash);
        }
        
        // STEP 4: Create a security string for the current request .... SECURED_STRING = REQUEST_TYPE + ENDPOINT + TIMESTAMP + ENCODED_PAYLOAD;)
        $securedString = $httpMethod . $endpoint . $timestamp . $encodedPayload;

        // STEP 5: Do a UTF-8 ENCODING  of the Secured String
        $encodedSecuredString = utf8_encode($securedString);

        // STEP 6: Sign the encoded secured string using HMAC (SHA-1) with your user secret
        // HASH_SIGNATURE = HASH_HMAC_SHA1( Key: YOUR_USER_SECRET, Message:  ENCODED_SECURED_STRING )
        $hashSignature = hash_hmac("sha1", $encodedSecuredString, self::USER_SECRET, true);

        // STEP 7:  Convert the HASH_SIGNATURE to base 64.
        // FINAL_SIGNATURE = ConvertToBase64(HASH_SIGNATURE)
        $finalSignature = base64_encode($hashSignature);

        return $finalSignature;
    }

}