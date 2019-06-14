<?php

namespace App;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sdkcodes\LaraPaystack\PaystackService;

class Supplier extends Model
{
    protected $guarded = [];

    public function paymentHistory(){
    	return $this->hasMany(PaymentHistory::class, 'supplier_id');
    }
    public function createAsTransferRecipient(){
        $pay = new PaystackService;
        if (!is_null($this->getBankCode())){
            $data = $pay->createTransferRecipient([
                 'type' => 'nuban',
                 'name' => $this->name,
                 'description' => $this->name . " account",
                 "account_number" => $this->account_number,
                 "bank_code" => $this->getBankCode(),
                 "currency" => "NGN"
            ]);
            $this->paystack_transfer_code = $data->data->recipient_code;
            $this->save();
            
        }
    }
    public function getBank(){
        return DB::table('banks')->where('name', $this->bank_name)->first();
    }
    public function hasValidBank(){
        if (DB::table('banks')->where('name', $this->bank_name)->count() > 0){
            return true;
        }
        return false;
    }
    public function getBankCode(){
        if ($this->hasValidBank()){
            return $this->getBank()->code;
        }
    }

    public function doPaystackTransfer($amount){
        $pay = new PaystackService;
        $amount = \intval($amount);
        try {
            $response = $pay->initiateTransfer([
             'source' => 'balance',
             'reason' => config('app.name') . " Payout",
             'amount' => "$amount",
             'recipient' => "{$this->paystack_transfer_code}"
            ]);
            
            return true;
        } catch (ClientException $e) {

            // echo $e->getResponse()->getBody();
            $error = json_decode($e->getResponse()->getBody());
            
            
            if ($error->status == false){
                throw new \Exception("INSUFFICIENT_BALANCE", 1);
            }
            return false;
        }
        catch(\Exception $e){
            
            // dd($e->getMessage());
        };
        
    }
}
