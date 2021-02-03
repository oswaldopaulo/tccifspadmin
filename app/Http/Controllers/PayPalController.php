<?php

namespace App\Http\Controllers;

use Request;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use \App\Http\Controllers\ParametrosController as Par;


class PayPalController extends Controller
{
    public function __construct()
    
    {
        
    $paypal_conf =   [ 
                'client_id' => "AQ-P_PJIAMCvJjPdo7U7wrNOfOc05m8niPvIlkBZnRRhp7x-ZFUJqOYyhCVtnapGF6t3tzYVHpTP2rpm",
                'secret' => "EEizrm6lDR5MiysdbvVoOmS4FMz3ca4lljbxq2Yag10pm6c_hivjR99zjBaV0OyNjyiXuJQFqNO5zFL-",
                'settings' => array(
                    'mode' => "sandbox",
                    'http.ConnectionTimeOut' => 30,
                    'log.LogEnabled' => true,
                    'log.FileName' => storage_path() . '/logs/paypal.log',
                    'log.LogLevel' => 'ERROR'
                ),
            ];
        
        
        
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            
            $paypal_conf['client_id'],
            
            $paypal_conf['secret'])
            
            );
        
        
        
        
        $this->_api_context->setConfig($paypal_conf['settings']);
        
    }
    
    public function payWithpaypal($id)  {
        
        
       
      
        
        $trans =  DB::table('transacoes')->where(['id'=>$id])->get();
        $itens =  DB::table('transacoes_itens')->where(['id_trans'=>$id])->get();
        
        
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        
        $itenspay = Array(); 
        
        foreach($itens as $item){
        
            $item_1 = new Item();
            $item_1->setName($item->description)
            ->setCurrency('BRL')
            ->setQuantity($item->quantity)
            ->setPrice($item->price_unit);
            
            array_push($itenspay, $item_1);
         }
            
        if($trans[0]->valorfrete > 0){
          $item_1 = new Item();
            $item_1->setName("Frete")
            ->setCurrency('BRL')
            ->setQuantity(1)
            ->setPrice($trans[0]->valorfrete);
            
            array_push($itenspay, $item_1);
        }
        
        $item_list = new ItemList();
        //$item_list->setItems(array($item_1));
        $item_list->setItems($itenspay);
        
        $amount = new Amount();
        $amount->setCurrency('BRL')
        ->setTotal($trans[0]->total + $trans[0]->valorfrete);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Compra transacao ' . $trans[0]->id );
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl('http://litegroup.com.br/tccifsp/public/v1/paypal/status/' . $id)
        ->setCancelUrl('http://litegroup.com.br/tccifsp/public/v1/paypal/status/' . $id);
        $payment = new Payment();
        $payment->setIntent('Sale')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
      
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            
           // return var_dump($ex);
            if (\Config::get('app.debug')) {
                session(['error' => 'Connection timeout']);
                return Redirect::route('paywithpaypal');
            } else {
                session(['error' => 'Some error occur, sorry for inconvenient']);
                return Redirect::route('paywithpaypal');
            }
        }
        
     
        
        
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
       
        session(['paypal_payment_id' => $payment->getId()]);
        
        DB::table('transacoes')
        ->where('id',$id)
        ->update([
            'payment_id'=>$payment->getId()
        ]);
        
        
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
       // \Session::put('error', 'Unknown error occurred');
        session(['error'  => 'Unknown error occurred']);
        return Redirect::route('paywithpaypal');
    }

    public function getPaymentStatus($id)
    {
       
       
        $trans =  DB::table('transacoes')->where(['id'=>$id])->get();
		$sucess['soma'] = DB::table('transacoes_itens')->sum('price_unit');
        
		$sucess['pedido'] = $id;
		
        
        if($trans[0]){
            if(!empty($trans[0]->paypal_toke)){
                return redirect()->to(url('/compras'))->with(['sucess'=>$sucess]);
            }
            
        }
        
        
		if(!DB::table('paypal_url')->where(['url'=>Request::fullurl()])->exists()){
         DB::table('paypal_url')
                        ->insert([
                        'idusuario'=>$trans[0]->iduser,
                        'idtrans'=>$id,
                        'url'=>Request::fullurl(),
                        

                    ]);
		}
        /** Get the payment ID before session clear **/
        $payment_id = Request::get('paymentId');
        
     
        /** clear the session payment ID **/
        //Session::forget('paypal_payment_id');
        
         try {
            session(['paypal_payment_id'=>null]);
            if (empty(Request::get('PayerID')) || empty(Request::get('token'))) {
                session(['error' => 'Payment failed']);
                return redirect()->to(url('404'));
            } 
            $payment = Payment::get($payment_id, $this->_api_context);
            $execution = new PaymentExecution();
            $execution->setPayerId(Request::get('PayerID'));
            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            
           return redirect()->to(url('/compras'))->with(['process'=>'1']);
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
         return redirect()->to(url('/compras'))->with(['process'=>'1']);
        
        }  catch (Exception $e) {
               
              return redirect()->to(url('/compras'))->with(['process'=>'1']);
             

            }
        
        if ($result->id != $trans[0]->payment_id){
            return redirect()->to(url('/404'));
        }
        if ($result->getState() == 'approved') {
            session(['success'=>'Payment success']);
            
            
         
            
            
            
            
            
              DB::table('transacoes')
            ->where(['payment_id'=>$payment_id,'id'=>$id])
            ->update([
                'paypal_toke'=>Request::get('token'),
                'paypal_payerid'=>Request::get('PayerID'),
                'status'=>'P'
            ]);
            
            
          
             DB::table('paypal_url')
                    ->where(['idtrans'=>$id])
                    ->update([
                        'status'=>'P',

                    ]);
            
            
               
           $trans_item = DB::table('transacoes_itens')
                    ->select('id_produto')
                    ->where(['id_trans'=>$id])
                    ->get();
            foreach($trans_item as $tran){
                
                   
                    DB::update("UPDATE loja SET demanda=demanda-1 where idproduto=" . $tran->id_produto . " and idempresa=" . $trans[0]->idempresa);
                    
               
            }
			
            
            
			
            return redirect()->to(url('/compras'))->with(['sucess'=>$sucess]);
        }
        session(['error' => 'Payment failed']);
        DB::table('transacoes')
        ->where(['payment_id'=>$payment_id,'id'=>$id])
        ->update([
            'paypal_toke'=>Request::get('token'),
            'paypal_payerid'=>Request::get('PayerID'),
            'status'=>'E'
        ]);
        return redirect()->to(url('/compras'));
    }
}
