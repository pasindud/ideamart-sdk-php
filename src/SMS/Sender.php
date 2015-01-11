<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart SMS Sender Class
*/

class SMSSender extends IdeamartCore{
      private $applicationId;
      private $password;
      private $charging_amount;
      private $encoding;
      private $version;
      private $deliveryStatusRequest;
      private $binaryHeader;
      private $sourceAddress;
      private $server;
  
  /* Send the server name, app password and app id
  * Dialog Production Severurl : HTTPS : - https://api.dialog.lk/sms/send
  *            HTTP  : - http://api.dialog.lk:8080/sms/send
  */    
  public function __construct($serverURL=null, $applicationId=null, $password=null,$log_state=1,$log_file="ideamart.log")
  {
    if((isset($serverURL, $applicationId, $password))){
      $this->setUp($serverURL,$applicationId,$password,$log_state,$log_file);
    }
  }

  //  Setup SMSSender
  public function setup($serverURL,$applicationId,$password,$log_state,$log_file)
  {
    $this->applicationId = $applicationId;
    $this->password = $password;
    $this->serverURL = $serverURL;
    $this->logInit($log_state,$log_file);
  }
  // Send a message to the user with a address or send the array of addresses
  public function sms($message, $addresses){
    if (!is_array($addresses)) {
      $addresses = array($addresses);
    }

    $this->log_message("SMS Message='".$message."' To=".json_encode($addresses),'debug');

    $payload = $this->makePayload($message, $addresses);
    
    // Make the api request
    $res = $this->makeRequest($message,$addresses);

    $this->log_message("API SMS Reponse=".$res,'debug');

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }

  public function makeRequest($message,$addresses)
  {
    return $this->sendRequest($message,$addresses);
  }
  
  // Encode json for POST
  public function makePayload($message, $addresses){
    
    $messageDetails = array("message"=>$message,
                        "destinationAddresses"=>$addresses
                    );

    if (isset($this->sourceAddress)) {
      $messageDetails= array_merge($messageDetails,array("sourceAddress" => $this->sourceAddress));   
    }
    
    if (isset($this->deliveryStatusRequest)) {
      $messageDetails= array_merge($messageDetails,array("deliveryStatusRequest" => $this->deliveryStatusRequest));
    }
    
    if (isset($this->binaryHeader)) {
      $messageDetails= array_merge($messageDetails,array("binaryHeader" => $this->binaryHeader));
    } 
    
    if (isset($this->version)) {
      $messageDetails= array_merge($messageDetails,array("version" => $this->version)); 
    } 
    
    if (isset($this->encoding)) {
      $messageDetails= array_merge($messageDetails,array("encoding" => $this->encoding)); 
    }

    $applicationDetails = array('applicationId'=>$this->applicationId,
             'password'=>$this->password,);
    
    $jsonStream = json_encode($applicationDetails+$messageDetails);

    return $jsonStream;
  }

  public function setapplicationId($applicationId){
    $this->applicationId=$applicationId;
  }

  public function setserverURL($serverURL){
    $this->serverURL=$serverURL;
  }

  public function setpassword($password){
    $this->password=$password;
  }

  public function setsourceAddress($sourceAddress){
    $this->sourceAddress=$sourceAddress;
  }

  public function setencoding($encoding){
    $this->encoding=$encoding;
  }

  public function setversion($version){
    $this->version=$version;
  }

  public function setbinaryHeader($binaryHeader){
    $this->binaryHeader=$binaryHeader;
  }

  public function setdeliveryStatusRequest($deliveryStatusRequest){
    $this->deliveryStatusRequest=$deliveryStatusRequest;
  }
}

