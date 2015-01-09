<?php

/**
 * 
 */
  
date_default_timezone_set("Asia/Colombo");

require "../vendor/autoload.php";

class ClassName extends PHPUnit_Framework_TestCase
{
    
    public function testSendArgs()
    {
        try {
            $sender = new SMSSender("localhost", "APP001");
            $this->fail("Expected exception not thrown");
            
        }
        catch (Exception $e) {
            $this->assertEquals("Server Url, App Id and Password are required", $e->getMessage());
        }   
    }
    
    public function testSmsMakePayload()
    {
        $sender = new SMSSender("localhost", "APP001", "password");
        
        $res = $sender->makePayload("hello", array(
            "tel:94123123123"
        ));
        $res = json_decode($res, true);
        
        $this->assertEquals($res["applicationId"], "APP001");
        $this->assertEquals($res["password"], "password");
        $this->assertEquals($res["message"], "hello");
        $this->assertEquals($res["destinationAddresses"][0], "tel:94123123123");
    }
    
    public function testSmsMakePayloadWithAdditionalSettings()
    {
        
        $sender = new SMSSender("localhost", "APP001", "password");
        $sender->setsourceAddress("77000");
        $res = $sender->makePayload("hello", array(
            "tel:94123123123"
        ));
        $res = json_decode($res, true);
        
        $this->assertEquals("77000", $res["sourceAddress"]);
        $this->assertEquals($res["applicationId"], "APP001");
        $this->assertEquals($res["password"], "password");
        $this->assertEquals($res["message"], "hello");
        $this->assertEquals($res["destinationAddresses"][0], "tel:94123123123");
    }
    
    public function testSendingSMSWithSucessStatus()
    {
        $stub = $this->getMockBuilder('SMSSender')
                     ->setConstructorArgs(array("localhost","APP001","password"))
                     ->setMethods(array('makeRequest'))
                     ->getMock();
        
        $stub ->method('makeRequest')
              ->will($this->returnValue('{"statusCode": "S1000","statusDetail": "Success"}'));
        
        $res = $stub->sms("hello text", "tel:94123123123");


        $this->assertEquals( "S1000" , $res->statusCode);
    }  

    public function testSendingSMSWithOtherStatus()
    {
        $stub = $this->getMockBuilder('SMSSender')
                     ->setConstructorArgs(array("localhost","APP001","password"))
                     ->setMethods(array('makeRequest'))
                     ->getMock();
        
        $stub ->method('makeRequest')
              ->will($this->returnValue('{"statusCode": "S1001","statusDetail": "Incorrect"}'));
        

        try {
            $res = $stub->sms("hello text", "tel:94123123123");
        }
        catch (Exception $e) {
            $this->assertEquals("Incorrect", $e->getMessage());
            $this->assertEquals("S1001", $e->getErrorCode());
        }
    }

    public function testSendingSMSWithWrongServerUrl()
    {
        $stub = $this->getMockBuilder('SMSSender')
                     ->setConstructorArgs(array("localhost","APP001","password"))
                     ->setMethods(array('makeRequest'))
                     ->getMock();
        
        $stub ->method('makeRequest')
              ->will($this->returnValue(''));
        
        try {
            $res = $stub->sms("hello text", "tel:94123123123");
        }
        catch (Exception $e) {
            $this->assertEquals("Incorrect Server Url check it again", $e->getMessage());
        }
    }
    
    // TODO Find a way to test this
    public function testSendingBroadcast()
    {
      // PHPUnit Observe   
    }
}








