<?php
/**
* Author : Pasindu De Silva
* Licence : MIT License
* http://opensource.org/licenses/MIT
* 
* Ideamart Core Class
*/


/**
*   TODO Ability to drop this dependence and do custom loggin
*/
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class IdeamartCore
{
    public function sendRequest($jsonStream, $url)
    {

        $this->log_message("Core Request Url='".$url."' payload='".$jsonStream."'",'debug');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStream);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);

        $this->log_message("Core Response Url='".$url."' payload='".$res."'",'debug');
        return $res;
    }


    public $log_state = 1;
    public $log;
    public $log_file;

    public function logInit($log_state,$log_file,$log_name="podi",$manage=false)
    {
        $this->log_state = $log_state;
        $this->log_file = $log_file;
        $this->log = new Logger($log_name);
        $this->setLogStreams();
        $this->log_message("Intiated Logging",'info');
    }

    public function setLogStreams()
    {
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::DEBUG));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::INFO));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::NOTICE));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::WARNING));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::ERROR));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::CRITICAL));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::ALERT));
        $this->log->pushHandler(new StreamHandler($this->log_file, Logger::EMERGENCY));
    }

    public function log_message($message,$type="debug")
    {
        if ($this->log_state==1) {
          $logFunName="add".ucfirst($type); // Make info to Info
          $this->log->$logFunName($message);
      }
  }
}
