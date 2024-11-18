<?php
// Written and developed by erfan Asadi
include "config.php";
header('Content-Type: application/json');
date_default_timezone_set('Asia/Tehran');
$username = '-----'; // input username
$amount = '-----'; // input money
$res = CheckRes(CreatePay($amount,$callback,$Merchent_ID,$sandbox));
if(DBpayment($res,$username,$amount)){
  echo $res;
  // The payment gateway has been created successfully!
}else{
  echo '{"Status_det":"NOK","Message":"Unknown error!","Code":40}';
  // Unknown error!
}

function CreatePay($amount,$callback,$key,$sandbox){
    $data = '{
      "merchant_id": "'.$key.'",
      "amount": "'.$amount.'",
      "callback_url": "'.$callback.'",
      "currency": "IRT",
      "description": "تراکنش جهت خرید کالا و خدمات",
      "metadata": {
      }
    }';
    if($sandbox){
        $URL = 'https://sandbox.zarinpal.com/pg/v4/payment/request.json';
    }else{
        $URL = 'https://payment.zarinpal.com/pg/v4/payment/request.json';
    }
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $URL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => $data,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function CheckRes($resultD){
  include "config.php";
  $result = json_decode($resultD,true);
  if(empty($result['errors'])){
    if ($result['data']['code'] == 100) {
      $auth = $result['data']["authority"];
      if($sandbox){
        $Link = 'https://sandbox.zarinpal.com/pg/StartPay/' . $auth;
      }else{
        $Link = 'https://www.zarinpal.com/pg/StartPay/' . $auth;
      }
      return '{"Status_det":"OK","Message":"Successfully Invoice!","Link":"'.$Link.'","Authority":"'.$auth.'","Code":100}';
      // The payment gateway has been created successfully!
    } else {
      return '{"Status_det":"NOK","Message":"error System!","test":"'.json_encode($resultD).'","Code":500}';
      // System error!
    }
  } else {
  $error = $result['errors']['message'];
  $RCode = $result['data']['code'];
    return '{"Status_det":"NOK","Message":"'.$error.'","Code":"'.$RCode.'"}';
    // Defined error in ZarinPal system!
  }
}

function DBpayment($result,$username,$Amount){
  include "config.php";
  $res = json_decode($result,true);
  $Authority = $res["Authority"];
  $Date = date('Y-m-d h:i:s');
  $sqlquery = "INSERT INTO Transaction(username,Authority,Amount,Status,Message,ref_id,Date,DatePayed) VALUES (?,?,?,?,?,?,?,?) ";
  $result2 = $pdo->prepare($sqlquery);
  if ($result2->execute([
    $username,
    $Authority,
    $Amount,
    'NOK',
    'Awaiting payment...',
    'undefind',
    $Date,
    'Payment has not been pay!'
  ])) {
    return true;
  }else{
    return false;
  }
}