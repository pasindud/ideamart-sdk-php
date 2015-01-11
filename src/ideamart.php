<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart Class to interact with all the apis
*/

class Ideamart
{
  
  function __construct(){}

  public function init($appid,$password)
  { 
    $sms = new SMSSender();
    $broadcast = new SMSSender();

    //CAAS
    $balance = new CAAS();
    $debit = new CAAS();

    //USSD
    $ussdReceiver = new USSDReceiver();
    $ussdSender = new USSDSender();
    
    //LBS
    $locate = new LBS();

    //Subscription
    $register = new Subscription();
    $unregister = new Subscription();
    $base = new Subscription();
  }

}


