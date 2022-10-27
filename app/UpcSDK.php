<?php


namespace UPC;

use Gamegos\JWS\JWS;
use UPC\HttpClient;
use UPC\Sign;

class UpcSDK implements UpcInterface
{
    protected $private_key;

    public function __construct(
        $private_key_path,
        private bool $isFile = true
    )
    {
        $this->private_key = $private_key_path;
    }

    public function signature(UpcPaymentData $data): string
    {
        $formated_string = "$data->MerchantID;$data->TerminalID;$data->PurchaseTime;$data->OrderID;$data->Currency;$data->TotalAmount;;";
        openssl_sign($formated_string, $signature, $this->isFile ? file_get_contents($this->private_key): $this->private_key);

        return base64_encode($signature);
    }

    public function tranState(UpcPaymentData $data, string $url= "secure.upc.ua")
    {
        $jws_arr =  explode('.', $this->PaymentJWS($data));
        $payload = [
            'header' => $jws_arr[0],
            'payload' => $jws_arr[1],
            'Signature' => $jws_arr[2],
        ];

        $response = HttpClient::postJSON("https://$url/go/service/01", json_encode($payload));
        if($response){
            $parsed_response = json_decode($response);
            $result = json_decode(base64_decode($parsed_response->payload));
            return $result;
        }
        return null;
    }

    public function reversal($params, string $url= "secure.upc.ua"){
        $signature = Sign::reversalPaymentSign($params, $this->private_key, $this->isFile);

        $payload['Signature'] =  $signature;

        $response = HttpClient::post("https://$url/go/repayment", $payload);
        return $response;
    }

    public function PaymentJWS(UpcPaymentData $data): string
    {

        $headers = array(
            'alg' => 'RS256'
        );

        $payload = $data->toArray();

        $jws = new JWS();
        $private_key = $this->isFile ? file_get_contents($this->private_key): $this->private_key;
        $jws_string = $jws->encode($headers, $payload, $private_key);
        return $jws_string;
    }
}