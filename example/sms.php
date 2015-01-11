<?php


require "../vendor/autoload.php";

// Application Details
$applicationId= "APP_0001";
$password= "password";

$smsIn = new SMSReceiver();

$address = $smsIn->getAddress();
$message = $smsIn->getMessage();


$url = "http://localhost:7000/sms/send";
$smsOut = new SMSSender($url,$applicationId,$password);

$smsOut->sms("Got the message",$address);
$smsOut->broadcast("This message is broadcasted - ".$message);

