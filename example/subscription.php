<?php

require "../vendor/autoload.php";

// Application Details
$applicationId= "APP_0001";
$password= "password";
$subscriberId = "tel:94777123123";



$subscription = new Subscription();


// Setup Subscription to register and unregister users
$subcriptionUrl = "http://localhost:7000/subscription/send";
$subscription->setupSubcription($subcriptionUrl,$applicationId,$password);

// Register the following user
$res = $subscription->register($subscriberId);

var_dump($res);

// Setup Subcription Status to know whether the user is register, not register or
// pending registration
$statusUrl = "http://localhost:7000/subscription/getStatus";
$subscription->setupSubcription($statusUrl,$applicationId,$password);

// Get the status of the following user
$res = $subscription->status($subscriberId);


// Setup subcription base to get number of users registered
$statusUrl = "http://localhost:7000/subscription/getStatus";
$subscription->setupBase($applicationId,$password);


$res = $subscription->base();
var_dump($res);


// UnRegister the following user
$subscriberId = "tel:94777123123";
$res = $subscription->unregister($subscriberId);















