<?php

require_once('library/cipaypal.php');

class getPaypal
{
	function __construct($config = array())
	{	
		$this->paypal = new CiPayPal($config);
	}
	
	//Return array();
	function getTransaction($txn_id)
	{
		$fields = array(
							'transactionid' => $txn_id
						);
						
		$data = array('GTDFields'=>$fields);
		$paypal_data = $this->paypal->GetTransactionDetails($data);
		
		return $paypal_data;
	}
	
	//$fee = true -> user fee payment;
	//Return count money;
	function getMoney($txn_id)
	{
		$txn_data = $this->getTransaction($txn_id);
		if(isset($txn_data['AMT'])){
			$money = $txn_data['AMT'];
			return $money;
		}else
		{
			return false;
		}
	}
}

?>