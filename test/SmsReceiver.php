<?php


require "../src/SMS/Receiver.php";

class ClassName extends PHPUnit_Framework_TestCase
{

  public function sampleIdeamartSms()
  {
    $jsonRequest = new stdClass;
    $jsonRequest->version = "1";
    $jsonRequest->applicationId = "APP_0001";
    $jsonRequest->sourceAddress = "tel:947123123";
    $jsonRequest->message = "Hello World Test";
    $jsonRequest->requestId = "123123";
    $jsonRequest->encoding = "text";
    return $jsonRequest;
  }
  
  public function testSmsReceiverObjSetters()
  {
    $rec = new Receiver();
    $rec->setUpReceiver($this->sampleIdeamartSms());
    $this->assertEquals($rec->getVersion(), "1");
    $this->assertEquals($rec->getApplicationId(), "APP_0001");
    $this->assertEquals($rec->getAddress(), "tel:947123123");
    $this->assertEquals($rec->getMessage(), "Hello World Test");
    $this->assertEquals($rec->getRequestId(), "123123");
    $this->assertEquals($rec->getEncoding(), "text");
  }

  public function testSmsReceiverMakeRequest()
  {
    $rec = new Receiver();

    $json = $this->sampleIdeamartSms();
    $res = $rec->makeResponse($json);

    $this->assertEquals($res["statusDetail"], 'Process completed successfully.');
    $this->assertEquals($res["statusCode"], 'S1000');

    unset($json->sourceAddress);


    $res = $rec->makeResponse($json);

    $this->assertEquals($res["statusDetail"], 'Request is Invalid.');
    $this->assertEquals($res["statusCode"], 'E1312');
  }
}
