<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart LBS Class
*/

class LBS extends IdeamartCore
{
  public $serviceType = "IMMEDIATE";

  function __construct(){}

  public function setupLbs($url,$applicationId,$password)
  {
    $this->lbsApplicationId = $applicationId;
    $this->lbsPassword = $password;
    $this->lbsUrl = $url;
  }

  public function locate($subscriberId)
  {
    
    $jsonPayload = array(
      "applicationId"=> $lbsApplicationId,
      "password"=> $lbsPassword,
      "subscriberId"=> $subscriberId,
      "serviceType"=> $this->serviceType
    );

    if (isset($this->responseTime)) {
      $jsonPayload = array_merge($jsonPayload,array("responseTime"=>$this->responseTime));
    }

    if (isset($this->freshness)) {
      $jsonPayload = array_merge($jsonPayload,array("freshness"=>$this->freshness));
    }

    if (isset($this->horizontalAccuracy)) {
      $jsonPayload = array_merge($jsonPayload,array("horizontalAccuracy"=>$this->horizontalAccuracy));
    }

    if (isset($this->vesrion)) {
      $jsonPayload = array_merge($jsonPayload,array("vesrion"=>$this->vesrion));
    }

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->lbsUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }
  
}




