<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalServices
{
  // este trait es para poder consumir los servicios de cualquier api por medio de Guzzle

  public function makeRequest($method,$requestUrl, $queryParams = [], $formParams = [],
    $headers = [],$isJsonRequest = false ){

      // creo el cliente nuevo
      $client = new Client([
        'base_uri' => $this->baseUri,
      ]);
      
      if(method_exists($this, 'resolveAuthorization' )){
        //el resolveAuthorization esta en la clase del metodo de pago
        $this->resolveAuthorization($queryParams,$formParams,$headers);
    }


      //respuesta
      $response = $client->request($method,$requestUrl, [
         $isJsonRequest ? 'json' : 'form_params' => $formParams,
         'headers' => $headers,
         'query' => $queryParams
         ]);


      $response = $response->getBody()->getContents();

      if(method_exists($this, 'decodeResponse' )){
        // decodeResponse esta en la clase del metodo de pago
        $response = $this->decodeResponse($response);
      }
      

      
      return $response;
    }
}