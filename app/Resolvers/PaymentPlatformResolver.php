<?php

namespace App\Resolvers;

class PaymentPlatformResolver
{
    public function resolveService($PaymentPlatform)
    {
      //El nombre de la variable se haga en minuscula para leerlo en services.nombre.class
      $namePaymentPlatform = strtolower($PaymentPlatform);
      $service = config("services.{$namePaymentPlatform}.class");

      //Ejecuta la clase del metodo de pago
      if($service){
        return resolve($service);
      }

      throw new \Exception("Error con el servicio de plataforma de pago");
    }
}