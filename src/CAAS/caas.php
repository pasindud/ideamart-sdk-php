<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart CAAS Class
*/

class CAAS extends IdeamartCore
{

  public function setupBalance($queryBalanceUrl,$applicationId,$password)
  {
    $this->queryBalanceApplicationId = $applicationId;
    $this->queryBalancePassword = $password;
    $this->queryBalanceUrl = $url;
  }

  public function balance($subscriberId)
  {
    $jsonPayload = array(
          "applicationId"=> $this->queryBalanceApplicationId,
          "password"=> $this->queryBalanceApplicationId,
          "subscriberId"=> $subscriberId
        );

    //Conflict when debit used previously
    if (isset($this->paymentInstrumentName)) {
      $jsonPayload = array_merge($jsonPayload,array("paymentInstrumentName"=>$this->paymentInstrumentName));
    }

    if (isset($this->accountId)) {
      $jsonPayload = array_merge($jsonPayload,array("accountId"=>$this->accountId));
    }

    if (isset($this->currency)) {
      $jsonPayload = array_merge($jsonPayload,array("currency"=>$this->currency));
    }

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->queryBalanceUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  } 

  public function setupDebit($url,$applicationId,$password)
  {
    $this->debitApplicationId = $applicationId;
    $this->debitPassword = $password;
    $this->debitUrl = $url;
  }

  public function debit($subscriberId,$amount,$externalTrxId="")
  {
    $jsonPayload = array('applicationId' =>$this->debitApplicationId,
                         'password'=>$this->debitPassword,
                         'externalTrxId'=>$externalTrxId,
                         'subscriberId'=>$subscriberId,
                         'amount'=>$this->amount,
                  );

    //Conflict when query used previously
    if (isset($this->currency)) {
      $jsonPayload = array_merge($jsonPayload,array("currency"=>$this->currency));
    }
      
    if (isset($this->paymentInstrumentName)) {
      $jsonPayload = array_merge($jsonPayload,
        array("paymentInstrumentName"=>$this->paymentInstrumentName));
    }
       
    if (isset($this->accountId)) {
      $jsonPayload = array_merge($jsonPayload,
        array("accountId"=>$this->accountId));
    };

    // Send the request
    $res = $this->sendRequest($this->jsonPayload,$this->debitUrl);

    // Handle the response
    $res = $this->coreHandleResponse($res);

    return $res;
  }

}


