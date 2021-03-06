<?php

namespace App\Http\Controllers;
use App\Services\PaypalService;
use App\Resolvers\PaymentPlatformResolver;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
    protected $paymentPlatformResolver;
    
    public function __construct(PaymentPlatformResolver $paymentPlatformResolver)
    {
        $this->middleware('auth');
        
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }


    public function pay(Request $request)
    {
        $rules = [ 'value' => ['required','numeric','min:5']
        ];
        $request->validate($rules);

        dd($request->all());
        
        $paymentPlatform = $this->paymentPlatformResolver
                        ->resolveService($request->payment_platform);

        session()->put('paymentPlatform',$request->payment_platform);


        return $paymentPlatform->handlePayment($request);
    }

    public function approval()
    {
        if(session()->has('paymentPlatform')){
          $paymentPlatform = $this->paymentPlatformResolver
          ->resolveService(session()->get('paymentPlatform'));

          return $paymentPlatform->handleApproval();
        }
       return redirect()
       ->route('home')
       ->withErrors('We cannot retrieve your payment platform.Try again,please.');
    }

    public function cancelled()
    {
      
        return redirect()
        ->route('home')
        ->withErrors('Haz cancelado el pago');
    }
}
