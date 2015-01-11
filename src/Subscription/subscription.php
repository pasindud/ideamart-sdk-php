<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart Subscription Class
*/

class Subscription extends IdeamartCore
{

  function __construct($applicationId=null,$password=null){

    if ($applicationId!=null && $password!=null) {
      $this->subscriptionApplicationId = $applicationId;
      $this->subscriptionPassword = $password;
      $this->statusApplicationId = $applicationId;
      $this->statusPassword = $password;
      $this->baseApplicationId = $applicationId;
      $this->basePassword = $password;
    }

  }

  public function setupSubcription($url,$applicationId,$password)
  {
    $this->subscriptionApplicationId = $applicationId;
    $this->subscriptionPassword = $password;
    $this->subscriptionUrl = $url;
  }

  public function setupStatus($url,$applicationId,$password)
  {
    $this->statusApplicationId = $applicationId;
    $this->statusPassword = $password;
    $this->statusUrl = $url;
  }

  public function setupBase($url,$applicationId,$password)
  {
    $this->baseApplicationId = $applicationId;
    $this->basePassword = $password;
    $this->baseUrl = $url;
  }

  public function register($subscriberId)
  {
    return $this->subcription($subscriberId,"1");
  }

  public function unregister($subscriberId)
  {
    return $this->subcription($subscriberId,"0");
  }

  public function subcription($subscriberId,$action)
  {
    $jsonPayload = array(
        "applicationId"=>  $this->subscriptionApplicationId,
        "password"=> $this->subscriptionPassword,
        "version"=> $this->version,
        "action"=> $action,
        "subscriberId"=> $subscriberId
      );

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->subscriptionUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }

  public function status($subscriberId)
  {
    $jsonPayload = array(
        "applicationId"=>  $this->statusApplicationId,
        "password"=> $this->statusPassword,
        "subscriberId"=> $subscriberId
      );

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->statusUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }

  public function base()
  {
    $jsonPayload = array(
        "applicationId"=>  $this->baseApplicationId,
        "password"=> $this->basePassword
      );

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->baseUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }
  
  /*
  * TODO Implement
  */
  public function subscriptionNotification()
  {

  }
}