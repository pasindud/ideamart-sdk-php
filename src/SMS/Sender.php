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
  private $encoding;
  private $version;
  private $deliveryStatusRequest;
  private $binaryHeader;
  private $sourceAddress;
  private $serverURL;
  
  /* Send the server name, app password and app id
  * Dialog Production Severurl : HTTPS : - https://api.dialog.lk/sms/send
  *            HTTP  : - http://api.dialog.lk:8080/sms/send
  */    
  public function __construct($serverURL=null, $applicationId=null, $password=null,$log_state=1,$log_file="ideamart.log")
  {
    if(!(isset($serverURL, $applicationId, $password))){
      throw new IdeamartExceptions('Server Url, App Id and Password are required',1);
    } else {
      $this->applicationId = $applicationId;
      $this->password = $password;
      $this->serverURL = $serverURL;
    }

    $this->logInit($log_state,$log_file);
  
  }
  
  // Broadcast a message to all the subcribed users
  public function broadcast($message){
    $this->log_message("Broadcast Message='".$message."'",'debug');
    return $this->sms($message, array('tel:all'));
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

    // Handle the api response
    $res = $this->handleResponse($res);
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


  public function handleResponse($jsonResponse){

    if (empty($jsonResponse)) {
      throw new IdeamartExceptions("Incorrect Server Url check it again", 1); 
    }

    $jsonResponse = json_decode($jsonResponse);

    $statusCode = $jsonResponse->statusCode;
    $statusDetail = $jsonResponse->statusDetail;

    if (trim($statusCode)=="S1000") {
      return $jsonResponse;
    }else{
      throw new IdeamartExceptions($statusDetail,$statusCode); 
    }
    return false;
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

