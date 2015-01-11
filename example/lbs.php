<?php

require "../vendor/autoload.php";


$url = "http://localhost:7000/lbs/locate";
$applicationId= "APP_0001";
$password= "password";

$lbs = new LBS($url,$applicationId,$password);


$subscriberId = "tel:94777123123";

$res = $lbs->locate($subscriberId);


var_dump($res);

