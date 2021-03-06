<?php

namespace App\Services;
use App\Traits\ConsumesExternalServices;
use Illuminate\Http\Request;

class StripeService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $key;

    protected $secret;

    public function __construct()
    {
        $this->baseUri = config('services.stripe.base_uri');
        $this->key = config('services.stripe.key');
        $this->secret = config('services.stripe.secret');
    }

    /***************** CONFIGURACION INCIAL *****************************+*/
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        return "Bearer {$this->secret}";
    }

  

    public function handlePayment(Request $request)
    {
    
    }
    
    public function handleApproval()
    {
   
    }


    public function resolveFactor($currency)
    {
    $zeroDecimalCurrencies = ['JPY'];

    if(in_array(strtoupper($currency), $zeroDecimalCurrencies)){
        return 1;
    }
    return 100;
    }


}