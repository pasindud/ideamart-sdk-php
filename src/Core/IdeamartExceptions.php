<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart Exception Class
*/

class IdeamartExceptions extends Exception{
  private $statusCode,
  $statusDetail;

  public function __construct($message, $code){
    parent::__construct($message);

    $this->statusCode = $code;
    $this->statusDetail = $message;
  }

  public function getErrorCode(){
    return $this->statusCode;
  }

  public function getErrorMessage(){
    return $this->statusDetail;
  }
}
?>
