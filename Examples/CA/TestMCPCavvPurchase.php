<?php

## Example php -q TestPurchase-VBV.php "moneris" store

require "../../mpgClasses.php";

/******************************* Request Variables ********************************/

$store_id='monca02932';
$api_token='CG8kYzGgzVU5z23irgMx';

/****************************** Transactional Variables ***************************/

$type='mcp_cavv_purchase';
$order_id='ord-'.date("dmy-G:i:s");
$cust_id='CUST887763';
$amount='10.00';
$pan="4740611374762707";
$expiry_date="2211";
$cavv='BwABApFSYyd4l2eQQFJjAAAAAAA=';
$crypt_type = '7';
$wallet_indicator = "APP";
$dynamic_descriptor='123456';

$mcp_version = '1.0';
$cardholder_amount = '100';
$cardholder_currency_code = '840';
$mcp_rate_token = 'P1623680755788776';

/*************************** Transaction Associative Array ************************/

$txnArray=array(
			'type'=>$type,
	        'order_id'=>$order_id,
			'cust_id'=>$cust_id,
	        'amount'=>$amount,
	        'pan'=>$pan,
	        'expdate'=>$expiry_date,
			'cavv'=>$cavv,
			'crypt_type'=>$crypt_type, //mandatory for AMEX only
			//'wallet_indicator'=>$wallet_indicator, //set only for wallet transactions. e.g. APPLE PAY
			//'network'=> "Interac", //set only for Interac e-commerce
			'data_type'=> "3DSecure", //set only for Interac e-commerce
			'dynamic_descriptor'=>$dynamic_descriptor,
			'threeds_version' => '2', //Mandatory for 3DS Version 2.0+
			'threeds_server_trans_id' => 'e11d4985-8d25-40ed-99d6-c3803fe5e68f', //Mandatory for 3DS Version 2.0+ - obtained from MpiCavvLookup or MpiThreeDSAuthentication 
			//'cm_id' => '8nAK8712sGaAkls56', //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
	        //'ds_trans_id' => '12345', //Optional - to be used only if you are using 3rd party 3ds 2.0 service
            'mcp_version'=> $mcp_version,
            'cardholder_amount' => $cardholder_amount, 
            'cardholder_currency_code' => $cardholder_currency_code, 
            'mcp_rate_token' => $mcp_rate_token
		);

/****************************** Transaction Object *******************************/

$mpgTxn = new mpgTransaction($txnArray);

/******************* Credential on File **********************************/

$cof = new CofInfo();
$cof->setPaymentIndicator("U");
$cof->setPaymentInformation("2");
$cof->setIssuerId("139X3130ASCXAS9");

$mpgTxn->setCofInfo($cof);


/******************************* Request Object **********************************/

$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
$mpgRequest->setTestMode(true); //false or comment out this line for production transactions

/****************************** HTTPS Post Object *******************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/************************************* Response *********************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();

print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nISO = " . $mpgResponse->getISO());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());
print("\nCavvResultCode = " . $mpgResponse->getCavvResultCode());
print("\nIssuerId = " . $mpgResponse->getIssuerId());
print("\nThreeDSVersion = " . $mpgResponse->getThreeDSVersion());

print("\nMerchantSettlementAmount = " . $mpgResponse->getMerchantSettlementAmount());
print("\nCardholderAmount = " . $mpgResponse->getCardholderAmount());
print("\nCardholderCurrencyCode = " . $mpgResponse->getCardholderCurrencyCode());
print("\nMCPRate = " . $mpgResponse->getMCPRate());
print("\nMCPErrorStatusCode = " . $mpgResponse->getMCPErrorStatusCode());
print("\nMCPErrorMessage = " . $mpgResponse->getMCPErrorMessage());
print("\nHostId = " . $mpgResponse->getHostId());

?>

