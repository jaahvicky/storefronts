<?php

namespace App\Http\Helpers;
use DB;
use \App\Models\Store;
use \App\Models\StoreUser;
class CronHelper {
	const BILL_PAYMENT_DUE = 1;
	const STORE_TRAIL_PERIOD_DUE = 0;
	const STORE_INVOICE = 2;
	const STORE_TRAIL_PERIOD_END = 3;
	const STORE_INVOICE_DEBITED_SUBSCRIBE =4;
	const STORE_INVOICE_DEBITED_MERCHANT =5;
	const STORE_CLOSURE = 6;
	const STORE_PAYMENT_OVERDUE = 7;

	public function checkStoreTrailPeriod($store){
        $trial_period = $this->getTraildays($store);
        if($trial_period < 30){
        	return (object)['status'=> true, 'remaining_days'=> (30 - $trial_period)];
        }else{
        	return (object)['status'=> false];
        }
		
	}

	private function getTraildays($store){
		if($store->approved_at == null){
			return  0;
		}else{
			$store_date = date_create($store->approved_at);
			$now = date_create(date('Y-m-d H:m:s'));
	        $interval = date_diff($store_date, $now);
	        $trial_period = $interval->days;

	        return  $trial_period;
		}
		
	}

	public function checkStorePayment($store){
		$billing = $store->billing;

		if(empty($billing) && ($this->CheckPaymentDueDate($store) > 14)){
			
			if($this->CloseStore($store->id)){
				$this->Sendmail($store, CronHelper::STORE_CLOSURE);
			}
		}elseif(empty($billing) && ($this->CheckPaymentDueDate($store) == 8) ){ 
 			$this->Sendmail($store, CronHelper::STORE_PAYMENT_OVERDUE);

		}elseif(empty($billing) && ($this->CheckPaymentDueDate($store) == 0)){ 
 			$this->Sendmail($store, CronHelper::BILL_PAYMENT_DUE);

		}elseif(!empty($billing) && ($billing->status == 'pending') && ($this->CheckPaymentDueDate($store) == 8) ){ 
 			$this->Sendmail($store, CronHelper::STORE_PAYMENT_OVERDUE);

		}elseif(!empty($billing) && ($billing->status == 'pending') && ($this->CheckPaymentDueDate($store) > 14) ){
			if($this->CloseStore($store->id)){
				$this->Sendmail($store, CronHelper::STORE_CLOSURE);
			}
			
		}else{
				
		}
		
	}

	public function SendTrailExpire($store){
		$trail_days = $this->getTraildays($store);
		if($trail_days < 30 && (30 - $trail_days) == 7 ){
			$this->Sendmail($store, CronHelper::STORE_TRAIL_PERIOD_END);
		}
		
	}

	public function SendInvoice($store){
		$days = $this->CheckPaymentDueDate($store);
		if(($days > 3) && ($days <= 4)){ //send notification for payments

			$this->Sendmail($store, $this->CheckAccountType($store));
		}

		if($days == 0){//send invoice

			$this->Sendmail($store, CronHelper::STORE_INVOICE);
		}

	}
	private function CheckAccountType($store){
		if(!empty($store->ecocash) && $store->ecocash->account_type != 0){
			return CronHelper::STORE_INVOICE_DEBITED_SUBSCRIBE;
		}else{
			return CronHelper::STORE_INVOICE_DEBITED_MERCHANT;
		}
		
	}
	public function CheckPaymentDueDate($store){
		
		$activated_date = date("d", strtotime($store->approved_at));
		$currentday = date('d');
		$days = ((int)$currentday - (int)$activated_date);

		return $days;
		
	}

	private function CheckInvoiceDate($store){
		
		$activated_date = date("d", strtotime($store->approved_at));
		$currentday = date('d');
		if(((int)$currentday - (int)$activated_date) == 0){
			return true;
		}else{
			return false;
		}
		
	}

	public function getDateRange($store){
		$approved_date =date("d", strtotime($store->approved_at)).'/'.date('m/y');
		$sample_d =date('Y-m-').date("d", strtotime($store->approved_at));
		$DateTime = new \DateTime($sample_d);
		$date1 = $DateTime->format("Y-m-d");
		$DateTime->modify('+30 days');
 		$date = $DateTime->format("d/m/y");
 		return (String)($approved_date .' - '. $date);
	}

	public function CloseStore($id){
		$store = Store::where('id', $id)->first();
		$status = $store->status;
		if($store->store_status_type_id != Store::STATUS_TYPE_PENDING_REOPEN){
			$store->store_status_type_id = Store::STATUS_TYPE_PENDING_REOPEN;
			$store->save();
			return true;

		}else{
			return false;
		}

	}

	public function Sendmail($store, $msgstatus){

		switch ($msgstatus) {
			case CronHelper::STORE_TRAIL_PERIOD_DUE:
					$DateTime = new \DateTime();
					$DateTime->modify('+3 days');
 					$dates = $DateTime->format("l jS F Y ");
 					$store_link =  StoreUser::where('store_id',$store->id)->first();
					\Mail::send('cron.three_days', ['store'=>$store, 'date_data'=>$dates, 'username'=>$store_link->user->username], function ($message) use ($store){
			            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Payment Due');
			        });
				break;
			case CronHelper::BILL_PAYMENT_DUE:
					$DateTime = new \DateTime();
					//$DateTime->modify('+3 days');
 					$dates = $DateTime->format("l jS F Y ");
 					$store_link =  StoreUser::where('store_id',$store->id)->first();
					\Mail::send('cron.store_due', ['store'=>$store, 'date_data'=>$dates, 'username'=>$store_link->user->username], function ($message) use ($store){
			            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Payment Required');
			        });
				break;
			case CronHelper::STORE_PAYMENT_OVERDUE:
					$DateTime = new \DateTime();
					$DateTime->modify('+7 days');
 					$dates = $DateTime->format("l jS F Y ");
 					$store_link =  StoreUser::where('store_id',$store->id)->first();
					\Mail::send('cron.store_paymentoverdue', ['store'=>$store, 'date_data'=>$dates, 'username'=>$store_link->user->username], function ($message) use ($store){
			            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Payment Overdue');
			        });
				break;
			case CronHelper::STORE_TRAIL_PERIOD_END:
				$DateTime = new \DateTime();
					$DateTime->modify('+7 days');
 					$dates = $DateTime->format("l jS F Y ");
 					$store_link =  StoreUser::where('store_id',$store->id)->first();
					\Mail::send('cron.store_trial_end', ['store'=>$store, 'date_data'=>$dates, 'username'=>$store_link->user->username], function ($message) use ($store){
			            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Trial Expiry');
			        });
				break;
			// case CronHelper::STORE_INVOICE_DEBITED_MERCHANT:
			// 	print_r('{"sending notification to inform that payment must be made from the back-office ........"}');
			// 	break;
			// case CronHelper::STORE_INVOICE_DEBITED_SUBSCRIBE:
			// 	print_r('{"sending notification  to inform that account will be automatically debited........"}');
			// 	break;
			case CronHelper::STORE_CLOSURE:
				 $store_link =  StoreUser::where('store_id',$store->id)->first();
					\Mail::send('cron.store_closure', ['store'=>$store, 'username'=>$store_link->user->username], function ($message) use ($store){
			            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Suspended');
			        });
				break;
			default:
				
				break;
		}

	}

}