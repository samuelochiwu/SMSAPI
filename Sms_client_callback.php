<?php

/**
 * THIS API IS TO RETRIVE POST AND GET SMS GETWAY...
 * @copyright 2021
 */

class Sms_client_callback{
    
     private $integrationName = "";                private $to = array();                    private $from = "";              private $status = "";
     private $messageId = "";                      private $requestId = "";                  private $statusCode = "";        private $result_set = array();      
     private $response  = "";                      private $statusDescription = false;       private $clientMessageId = "";   private $apiKey = "";
     private $apikey    = "";                      private $sms_data = array();              private $get_url_flag = "";      private $timestamp = "";                                        
     private $replyMessageId = "";                 private $fromNumber = "";                 private $toNumber ="";           private $text = "";
     private $charset = "";                        private $udh = "";                        private $network = "";           private $keyword ="";
 
     
     //All endpoints for SMSAPI
     private $sms_enpoint_bulk        = "https://platform.clickatell.com/messages/rest/bulk";
     private $sms_enpoint             = "http://customer-server/client-callback/sms-status"; 
     private $get_sms_status_endpoin  = "http://customer-server/client-callback/sms-status";
     private $get_sms_client_endpoint = "http://customer-server/client-callback/sms-reply";
     
     public function __construct(){
        
        $this->integrationName         = (isset($_REQUEST['integrationName']) && ($_REQUEST['integrationName'] != "")) ? $_REQUEST['integrationName'] : "";
        $this->to                      = (isset($_REQUEST['to'])  && ($_REQUEST['to'] != "")) ?  $_REQUEST['to'] : "";
        $this->from                    = (isset($_REQUEST['from'])  && ($_REQUEST['from'] != "")) ?  $_REQUEST['from'] : "";
        $this->requestId               = (isset($_REQUEST['requestId'])  && ($_REQUEST['requestId'] != "")) ?  $_REQUEST['requestId'] : "";
        $this->clientMessageId         = (isset($_REQUEST['clientMessageId'])  && ($_REQUEST['clientMessageId'] != "")) ?  $_REQUEST['clientMessageId'] : "";
        $this->statusDescription       = (isset($_REQUEST['statusDescription']) && ($_REQUEST['statusDescription'] != "")) ?  $_REQUEST['statusDescription'] : "";
        $this->statusCode              = (isset($_REQUEST['statusCode'])  && ($_REQUEST['statusCode'] != "")) ?  $_REQUEST['statusCode'] : "";
        $this->status                  = (isset($_REQUEST['status'])  && ($_REQUEST['status'] != "")) ?  $_REQUEST['status'] : "";
        $this->messageId               = (isset($_REQUEST['messageId'])  && ($_REQUEST['messageId'] != "")) ?  $_REQUEST['messageId'] : "";
        $this->timestamp               = (isset($_REQUEST['timestamp'])  && ($_REQUEST['timestamp'] != "")) ?  $_REQUEST['timestamp'] : "";
        $this->fromNumber              = (isset($_REQUEST['fromNumber'])  && ($_REQUEST['fromNumber'] != "")) ?  $_REQUEST['fromNumber'] : "";
        $this->toNumber                = (isset($_REQUEST['toNumber'])  && ($_REQUEST['toNumber'] != "")) ?  $_REQUEST['toNumber'] : "";
        $this->replyMessageId          = (isset($_REQUEST['replyMessageId'])  && ($_REQUEST['replyMessageId'] != "")) ?  $_REQUEST['replyMessageId'] : "";
        $this->text                    = (isset($_REQUEST['text'])  && ($_REQUEST['text'] != "")) ?  $_REQUEST['text'] : "";
        $this->charset                 = (isset($_REQUEST['charset'])  && ($_REQUEST['charset'] != "")) ?  $_REQUEST['charset'] : "";
        $this->udh                     = (isset($_REQUEST['udh'])  && ($_REQUEST['udh'] != "")) ?  $_REQUEST['udh'] : "";
        $this->network                 = (isset($_REQUEST['network'])  && ($_REQUEST['network'] != "")) ?  $_REQUEST['network'] : "";
        $this->keyword                 = (isset($_REQUEST['keyword'])  && ($_REQUEST['keyword'] != "")) ?  $_REQUEST['keyword'] : "";
        
        
     }
    
     public function postSms(){ // this function handles single sms
        
   
       $this->sms_data =  array("integrationName"=>"$this->integrationName", array("to"=>"$this->to"), "from"=>"$this->from","requestId"=>"$this->requestId","clientMessageId"=>"$this->clientMessageId",
                                "statusDescription"=>"$this->statusDescription","statusCode"=>"$this->statusCode","status"=>"$this->status","messageId"=>"$this->messageId","timestamp"=>"$this->timestamp");
       $this->sms_data =  json_encode($this->sms_data);
      
      
       $this->result_set = $this->SmsCurl_post($this->sms_data, $this->sms_enpoint);
      
       // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
     public function post_client_sms(){ // this function handles bulck sms
    
       $this->sms_data =  array("integrationName"=>"$this->integrationName", array("fromNumber"=>"$this->fromNumber"), "toNumber"=>"$this->toNumber","requestId"=>"$this->requestId","clientMessageId"=>"$this->clientMessageId",
                                "statusDescription"=>"$this->statusDescription","statusCode"=>"$this->statusCode","status"=>"$this->status","messageId"=>"$this->messageId","timestamp"=>"$this->timestamp"
                                ,"replyMessageId"=>"$this->replyMessageId","text"=>"$this->text","charset"=>"$this->charset","udh"=>"$this->udh","network"=>"$this->network","keyword"=>"$this->keyword");
      
       $this->sms_data =  json_encode($this->sms_data);
      
       $this->result_set = $this->SmsCurl_post($this->sms_data, $this->get_sms_client_endpoint);
      
      // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
    
     public function getSms(){// this function handles retrieve sms
    
       $this->get_url_flag = $this->get_sms_status_endpoin."&integrationName = $this->integrationName&to=$this->to&from=$this->from&requestId=$this->requestId&clientMessageId=$this->clientMessageId&statusDescription=$this->statusDescription
       &statusCode=$this->statusCode&status=$this->status&messageId=$this->messageId&timestamp=$this->timestamp";
       
       $this->result_set = $this->SmsCurl_get($this->get_url_flag);
      
       // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
    public function getClient_reply(){// this function handles retrieve sms
    
    $this->get_url_flag = $this->get_sms_client_endpoint."&integrationName = $this->integrationName&to=$this->to&from=$this->from&requestId=$this->requestId&clientMessageId=$this->clientMessageId&statusDescription=$this->statusDescription
                             &statusCode=$this->statusCode&status=$this->status&messageId=$this->messageId&timestamp=$this->timestamp&toNumber=$this->toNumber&replyMessageId=$this->replyMessageId&text=$this->text
                             &text=$this->text&charset=$this->charset&udh=$this->udh&network=$this->network&keyword=$this->keyword";
       
       $this->result_set = $this->SmsCurl_get($this->get_url_flag);
      
       // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
    
    // This is the basic client url to be called for all post request data...
     private function SmsCurl_post($post_data, $endpoint){ 
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_POSTFIELDS => http_build_query($post_data),
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPHEADER =>array('Authorization: '.'APIKEY'),
        ));
        
        $this->response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            
          $this->response = json_decode($this->response, true);
          
        
        }
    return $this->response;
    }
    
    
    // This is the basic client url to be called for all get request data...
     private function SmsCurl_get($endpoint){
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => $endpoint,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER =>array('Authorization: '.'APIKEY'),
        ));
        
        $this->response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
        
          $this->response = json_decode($this->response, true);
          
        }
    return $this->response;
    }
  
}

?>