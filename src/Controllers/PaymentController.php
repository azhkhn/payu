<?php
namespace Tzsk\Payu\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tzsk\Payu\Helpers\FormBuilder;
use Tzsk\Payu\Helpers\Processor;

class PaymentController extends Controller
{
    /**
     * Got to payment.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('tzsk::payment_form', [
            'payment' => (new FormBuilder($request))->build()
        ]);
    }

    /**
     * After payment it will return here.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(Request $request)
    {
        $payment = (new Processor($request))->process();

        Session::put('tzsk_payu_data.payment', $payment);

        return redirect()->to(base64_decode($request->callback));
    }
}
