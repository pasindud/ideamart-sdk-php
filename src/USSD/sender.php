<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart USSD Sender Class
*/

class USSDSender extends IdeamartCore{
  private $applicationId;
  private $password;
  private $encoding="440";
  private $version;
  private $binaryHeader;
  private $sourceAddress;
  private $serverURL;
  
  public function __construct($serverURL=null, $applicationId=null, $password=null,$log_state=1,$log_file="ideamart.log")
  {
    if((isset($serverURL, $applicationId, $password))){
      $this->setup($serverURL,$applicationId,$password,$log_state,$log_file);
    }
  }

  public function setup($serverURL,$applicationId,$password,$log_state,$log_file)
  {
    $this->applicationId = $applicationId;
    $this->password = $password;
    $this->serverURL = $serverURL;
    $this->logInit($log_state,$log_file);
  }
  
  private function ussd($message,$destinationAddress,$sessionId,$ussdOperation="mo-cont")
  {
      $jsonPayload = array("applicationId" => $this->applicationId,
            "password" => $this->password,
            "message" => $message,
            "destinationAddress" => $destinationAddress,
            "sessionId" => $sessionId,
            "ussdOperation" => $ussdOperation,
            "encoding" => $this->encoding
      );

      // Send the request
      $res = $this->sendRequest($this->jsonPayload,$this->lbsUrl);

      // Handle the response
      $res = $this->coreHandleResponse($res);

      return $res;
  }
}

