<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart USSD Receiver Class
*/


class USSDReceiver
{
    private $sourceAddress; 
    private $message;
    private $requestId;
    private $applicationId;
    private $encoding;
    private $version;
    private $sessionId;
    private $ussdOperation;
    private $vlrAddress;
    private $thejson;

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
            $this->sessionId     = $jsonRequest->sessionId;
            $this->ussdOperation = $jsonRequest->ussdOperation;
    }


    public function getthejson(){
        return $this->thejson;
    }

    public function getAddress(){
        return $this->sourceAddress;
    }

    public function getMessage(){
        return $this->message;
    }

    public function getRequestID(){
        return $this->requestId;
    }

    public function getApplicationId(){
        return $this->applicationId;
    }

    public function getEncoding(){
        return $this->encoding;
    }

    public function getVersion(){
        return $this->version;
    }

    public function getSessionId(){
        return $this->sessionId;
    }

    public function getUssdOperation(){
        return $this->ussdOperation;
    }
}