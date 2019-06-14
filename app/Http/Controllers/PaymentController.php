<?php

namespace App\Http\Controllers;

use App\PaymentHistory;
use App\Supplier;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
	public function index(Request $request){
		$payments = PaymentHistory::latest()->paginate(30);
		return view('payments.index', compact('payments'));
	}
    public function paySupplier(Request $request, $supplierId){
    	$supplier = Supplier::findOrFail($supplierId);
    	if (!$supplier->hasValidBank()){
    	  
    	  return back()->with(['status' => 'error',  'message' => "The supplier does not have a valid bank account. Please update their profile with the correct details."], 409);
    	}

    	if (is_null($supplier->paystack_transfer_code)){
    		try{
    			$supplier->createAsTransferRecipient();	
    		}
    		catch(ClientException $ex){
    			$errorResponse = json_decode($ex->getResponse()->getBody());
    			if ($errorResponse->status == false){
    				return back()->with(['status' => 'error',  'message' => "The supplier does not have a valid bank account. Please update their profile with the correct details."], 409);
    			}
    		}
	    	
    	}

    	try {
    	  
	    	  $amount = $request->amount;
	    	  $paystack_amount = $amount * 100; // paystack charges in kobo, so we have to multiply amount by 100
	    	  if (!$supplier->doPaystackTransfer($paystack_amount)){
	    	    
	    	    return back()->with(['status' => 'error', 'message' => "Unable to process your payment now, please try later"], 411);
	    	  }

	    	  PaymentHistory::create([
	    	  	'supplier_id' => $supplier->id,
	    	  	'amount' => $amount
	    	  ]);
	    	  
	    	  return back()->with(['status' => 'success', 'message' => $supplier->name . ' has been successfully paid']);
    	} catch (\Exception $e) {
    	    if ($e->getMessage() == "INSUFFICIENT_BALANCE"){
    	      return back()->with(['status' => "error", "message" => "You do not have enough funds to complete this transfer. Please fund your paystack wallet"]);
    	    }
    	}
    }
}
