<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart SMS Receiver Class
*/

class SMSReceiver
{
    public $version;
    public $applicationId;
    public $sourceAddress;
    public $message;
    public $requestId;
    public $encoding;
    public $thejson;

    public function __construct()
    {   
            $payload =file_get_contents("php://input");
            $res = $this->handRequest($payload);
            header('Content-type: application/json');
            echo json_encode($res);
    }
    
    public function handRequest($payload)
    {
        $jsonRequest =json_decode($payload);
        return $response = $this->makeResponse($jsonRequest);
    }

    public function makeResponse($jsonRequest)
    {
        if (!((isset($jsonRequest->sourceAddress) && isset($jsonRequest->message)))) {
            $response = array(
                'statusCode' => 'E1312',
                'statusDetail' => 'Request is Invalid.'
            );
        } else {
     
            $response = array(
                'statusCode' => 'S1000',
                'statusDetail' => 'Process completed successfully.'
            );
            $this->setUpReceiver($jsonRequest);
        }
        return $response;
    }

    public function setUpReceiver($jsonRequest)
    {
            $this->thejson       = $jsonRequest;
            $this->version       = $jsonRequest->version;
            $this->applicationId = $jsonRequest->applicationId;
            $this->sourceAddress = $jsonRequest->sourceAddress;
            $this->message       = $jsonRequest->message;
            $this->requestId     = $jsonRequest->requestId;
            $this->encoding      = $jsonRequest->encoding;
    }

    // Get the version of the incomming message
    public function getVersion()
    {
        return $this->version;
    }
    
    // Get the encoding of the incomming message
    public function getEncoding()
    {
        return $this->encoding;
    }
    
    // Get the Application of the incomming message
    public function getApplicationId()
    {
        return $this->applicationId;
    }
    
    // Get the address of the incomming message
    public function getAddress()
    {
        return $this->sourceAddress;
    }
    
    // Get the Message of the incomming request 
    public function getMessage()
    {
        return $this->message;
    }
    
    // Get the unique requestId of the incomming message  
    public function getRequestId()
    {
        return $this->requestId;
    }
    
    // Get the json
    public function getJson()
    {
        return $this->thejson;
    }
    
}