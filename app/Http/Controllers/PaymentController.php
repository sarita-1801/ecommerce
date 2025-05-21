<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Str;


class PaymentController extends Controller
{
    public function paideSewa()
    {
        $amount = Session::get('total_amount', 0);
        $skey = '8gBm/:&EnhH.1/q'; // Your eSewa secret key
        $transaction_uuid = Str::random(10);
        $product_code = 'EPAYTEST';

        // Create signature
        $dataString = "total_amount={$amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";
        $hash = hash_hmac('sha256', $dataString, $skey, true); // Use HMAC with SHA-256
        $signature = base64_encode($hash); // Base64 encode the hash

        // Auto-submit the form to eSewa
        $form = '
        <form id="esewa_form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="'.$amount.'" required>
            <input type="hidden" name="tax_amount" value="0" required>
            <input type="hidden" name="total_amount" value="'.$amount.'" required>
            <input type="hidden" name="transaction_uuid" value="'.$transaction_uuid.'" required>
            <input type="hidden" name="product_code" value="'.$product_code.'" required>
            <input type="hidden" name="product_service_charge" value="0" required>
            <input type="hidden" name="product_delivery_charge" value="0" required>
            <input type="hidden" name="success_url" value="'.route('esewa.success').'" required>
            <input type="hidden" name="failure_url" value="'.route('esewa.failure').'" required>
            <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="hidden" name="signature" value="'.$signature.'" required>
            <input type="submit" value="Submit" style="opacity: 0;">
        </form>
        <script type="text/javascript">document.getElementById("esewa_form").submit();</script>
        ';

        return response($form);
    }

    public function storeAmount(Request $request)
    {
        // Store total amount in session before redirecting to eSewa
        $totalAmount = $request->input('total_amount'); // Get the total amount from the request
        Session::put('total_amount', $totalAmount);
        return redirect()->route('esewa.pay');
    }


    public function esewaSuccess(Request $request)
    {
        $refId = $request->refId;
        $total_amount = Session::get('total_amount'); // Retrieve stored amount

    // Verify payment with eSewa
    $response = Http::post('https://rc-epay.esewa.com.np/api/epay/verify', [
        'amount' => $total_amount,
        'transaction_uuid' => $request->transaction_uuid,
        'ref_id' => $refId,
    ]);

    if ($response['status'] == 'SUCCESS') {
        return view('esewa.success', compact('total_amount', 'refId'));
    } else {
        return redirect()->route('esewa.failure');
    }
    }

    public function esewaFailure()
    {
        return redirect()->route('esewa.failure')->with('failure','Failed to pay.');
    }
}
