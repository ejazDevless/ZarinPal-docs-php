<?php
// Written and developed by erfan Asadi
include "config.php";
header('Content-Type: application/json');
date_default_timezone_set('Asia/Tehran');
$Authority = $_GET['Authority'];
$check = CheckPay($Authority);
if ($check == '100'){
  $Amount = GetAmount($Authority);
  $res = CheckRes(VerifyPay($Authority,$Merchent_ID,$Amount,$sandbox));
  $DND = json_decode($res,true);
  if($DND['Message'] == 'UnSuccessfully Transaction!'){
    echo '{"Status_det":"NOK","Message":"UnSuccessfully Transaction!","Code":52}';
    // This transaction has not been paid yet!
  }else{
    if(DBpayment($res,$Authority)){
      echo $res;
      // This transaction is completely correct and successfully completed!
    }else{
      echo '{"Status_det":"NOK","Message":"Unknown error!","Code":40}';
      // Unknown error!
    }
  }
}elseif ($check == '101'){
 echo '{"Status_det":"NOK","Message":"Repetitive transaction!","Code":101}';
// This transaction has already been confirmed!
}elseif ($check == '400'){
  echo '{"Status_det":"NOK","Message":"Notfound transaction!","Code":55}';
// The transaction was not found in the system!
}else{
  echo '{"Status_det":"NOK","Message":"Unknown transaction!","Code":39}';
// Unknown error!
}




function VerifyPay($Authority,$key,$Amount,$sandbox){
  $data = '{
    "merchant_id": "'.$key.'",
    "amount": "'.$Amount.'",
    "authority": "'.$Authority.'"
  }';
  if($sandbox){
    $URL = 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json';
  }else{
    $URL = 'https://payment.zarinpal.com/pg/v4/payment/verify.json';
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
  $result = json_decode($resultD,true);
  if(empty($result['errors'])){
    if ($result['data']['code'] == 100) {
      $ref = $result['data']['ref_id'];
      return '{"Status_det":"OK","Message":"Successfully Transaction!","ref_id":"'.$ref.'","Code":100}';
      // This transaction is completely correct and successfully completed!
    } else {
      return '{"Status_det":"NOK","Message":"error System!","test":"'.json_encode($resultD).'","Code":500}';
      // System error!
    }
  } else {
    $error = $result['errors']['message'];
    $RCode = $result['errors']['code'];
    if($RCode == -51){
      return '{"Status_det":"NOK","Message":"UnSuccessfully Transaction!","Code":52}';
      // This transaction has not been paid yet!
    }else{
      return '{"Status_det":"NOK","Message":"'.$error.'","Code":"'.$RCode.'"}';
      // Defined error in ZarinPal system!
    }
  }
}

function CheckPay($Authority){
  include "config.php";
  $sqlquery = "SELECT `Status`FROM `Transaction` WHERE `Authority` = ?";
  $result2 = $pdo->prepare($sqlquery);
  if ($result2->execute([
    $Authority
  ])) {
    $Status = $result2->fetchAll()[0]['Status'];
  }
  if($Status == ''){
    return 400; // Notfound transaction!
  }else{
    if ($Status == 'OK'){
      return 101;  // Repetitive transaction!
    }elseif ($Status == 'NOK') {
      return 100; // Next!
    }else{
      return 301; // Unknown transaction!
    }
  }
}

function GetAmount($Authority){
  include "config.php";
  $sqlquery = "SELECT `Amount`FROM `Transaction` WHERE `Authority` = ?";
  $result2 = $pdo->prepare($sqlquery);
  if ($result2->execute([
    $Authority
  ])) {
    return $result2->fetchAll()[0]['Amount'];
  }
}

function DBpayment($result,$Authority){
  include "config.php";
  $res = json_decode($result,true);
  $Status = $res["Status_det"];
  $Message = $res["Message"];
  $ref_id = $res["ref_id"];
  $DatePayed = date('Y-m-d h:i:s');
  $sqlquery = "UPDATE `Transaction` SET `Status`= ?,`Message`= ?,`ref_id`= ?,`DatePayed`= ? WHERE `Authority` = ?";
  $result2 = $pdo->prepare($sqlquery);
  if ($result2->execute([
    $Status,
    $Message,
    $ref_id,
    $DatePayed,
    $Authority
  ])) {
    return true;
  }else{
    return false;
  }
}