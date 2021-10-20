<?php

/**
 * THIS API IS TO RETRIVE POST AND GET SMS GETWAY...
 * @copyright 2021
 */

class SmsAPI{
    
     private $content = "";               private $to = array();         private $from = "";              private $charset = "";
     private $scheduledDeliveryTime = ""; private $validityPeriod = 0;   private $userDataHeader = "";    private $result_set = array();      
     private $response = "";              private $binary = false;       private $clientMessageId = "";   private $apiKey = "";
     private $apikey = "";                private $sms_data = array();   private $get_url_flag = "";                                        
     
     
     //All endpoints for SMSAPI
     private $sms_enpoint_bulk = "https://platform.clickatell.com/messages/rest/bulk";
     private $sms_enpoint      = "https://platform.clickatell.com/messages"; 
     private $get_sms_endpoint = "https://platform.clickatell.com/messages/http/send";
     
     public function __construct(){
        
        $this->content                 = (isset($_REQUEST['content']) && ($_REQUEST['content'] != "")) ? $_REQUEST['content'] : "";
        $this->to                      = (isset($_REQUEST['to'])  && ($_REQUEST['to'] != "")) ?  $_REQUEST['to'] : "";
        $this->from                    = (isset($_REQUEST['from'])  && ($_REQUEST['from'] != "")) ?  $_REQUEST['from'] : "";
        $this->binary                  = (isset($_REQUEST['binary'])  && ($_REQUEST['binary'] != "")) ?  $_REQUEST['binary'] : "";
        $this->clientMessageId         = (isset($_REQUEST['clientMessageId'])  && ($_REQUEST['clientMessageId'] != "")) ?  $_REQUEST['clientMessageId'] : "";
        $this->scheduledDeliveryTime   = (isset($_REQUEST['scheduledDeliveryTime']) && ($_REQUEST['scheduledDeliveryTime'] != "")) ?  $_REQUEST['scheduledDeliveryTime'] : "";
        $this->validityPeriod          = (isset($_REQUEST['validityPeriod'])  && ($_REQUEST['validityPeriod'] != "")) ?  $_REQUEST['validityPeriod'] : "";
        $this->userDataHeader          = (isset($_REQUEST['userDataHeader'])  && ($_REQUEST['userDataHeader'] != "")) ?  $_REQUEST['userDataHeader'] : "";
        $this->charset                 = (isset($_REQUEST['charset'])  && ($_REQUEST['charset'] != "")) ?  $_REQUEST['charset'] : "";
        
     }
    
     public function postSms(){ // this function handles single sms
        
   
       $this->sms_data =  array("content"=>"$this->content", array("to"=>"$this->to"), "from"=>"$this->from","binary"=>"$this->binary","clientMessageId"=>"$this->clientMessageId",
                                "scheduledDeliveryTime"=>"$this->scheduledDeliveryTime","validityPeriod"=>"$this->validityPeriod","userDataHeader"=>"$this->userDataHeader","charset"=>"$this->charset");
       $this->sms_data =  json_encode($this->sms_data);
       $this->result_set = $this->SmsCurl_post($this->sms_data, $this->sms_enpoint);
       // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
     public function postBulkSms(){ // this function handles bulck sms
    
       $this->sms_data   = array("messageList" => array("content"=>"$this->content", array("to"=>"$this->to"), "from"=>"$this->from","binary"=>"$this->binary","clientMessageId"=>"$this->clientMessageId",
                             "scheduledDeliveryTime"=>"$this->scheduledDeliveryTime","validityPeriod"=>"$this->validityPeriod","userDataHeader"=>"$this->userDataHeader","charset"=>"$this->charset"));
        
       $this->sms_data   =  json_encode($this->sms_data);
       $this->result_set = $this->SmsCurl_post($this->sms_data, $this->sms_enpoint_bulk);
       // The data returned will be what should be stored to database...
       return $this->result_set;
    }
    
    
     public function getSms(){// this function handles retrieve sms
    
       $this->get_url_flag = $this->get_sms_endpoint."&apiKey = $this->apiKey&to=$this->to&from=$this->from&content=$this->content&clientMessageId=$this->clientMessageId";
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