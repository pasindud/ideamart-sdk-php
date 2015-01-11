<?php
require "../vendor/autoload.php";

// Application Details
$applicationId= "APP_0001";
$password= "password";
$subscriberId = "tel:94777123123";


$caas = new CAAS();

// Setup CAAS Balance Request
$queryBalanceUrl = "http://localhost:7000/caas/balance/query";
$caas->setupBalance($queryBalanceUrl,$applicationId,$password);

// Get the balance of the user
$res = $caas->balance($subscriberId);

var_dump($res);

// Setup CAAS Balance Request
$queryBalanceUrl = "http://localhost:7000/caas/balance/query";
$caas->setupDebit($queryBalanceUrl,$applicationId,$password);

// Debit the user Rs. 5
$amount = "5";
$res = $caas->debit($subscriberId,$amount);

var_dump($res);







