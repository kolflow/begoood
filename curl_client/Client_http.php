<?php



/*{"developerMessage" : "Verbose, plain language description of
the problem for the app developer with hints about how to fix
it.", "userMessage":"Pass this message on to the app user if
needed.", "errorCode" : 12345, "more info":
 
 */

class Client_http {
   
    private $ch;
    
    public function __construct() {
        $this->init();
        
    }
    
    public function init(){
        $this->ch = curl_init();
    }
    
    public function json() {
        curl_setopt ($this->ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/json"));

    }
    
    public function acceptJson(){
         curl_setopt($this->ch,CURLOPT_HTTPHEADER,Array ("Accept: application/json"));
    }
    
     public function contentType_encoding() {
        curl_setopt ($this->ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/x-www-form-urlencoded"));

    }
    public function GET($url){
        
        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_HTTPGET,true);
        
        $result = curl_exec($this->ch);
        
        if(curl_errno($this->ch)){
            if($this->debug){
	
                $str .= "Error number: " .curl_errno($this->ch) ."\n";
		$str .= "Error message: " .curl_error($this->ch)."\n";
            
                json_encode($str);
            }
            return false;
	}else{
        	return $result;
	}
        
        
    }
    public function POST($url , $data){
        
        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($this->ch);
        
        if(curl_errno($this->ch)){
            if($this->debug){
		$str = "Error Occured in Curl\n";
                $str .= "Error number: " .curl_errno($this->ch) ."\n";
		$str .= "Error message: " .curl_error($this->ch)."\n";
            
                json_encode($str);
            }
            return false;
	}else{
        	return $result;
	}

        
    }

    /**
* implements an http put with parameters 
* @var $data Array
* @var $url string containing the url to make the put
*/
    public function PUT($url, $data){
        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "PUT");
        
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($this->ch);
        
        if(curl_errno($this->ch)){
            if($this->debug){
		$str = "Error Occured in Curl\n";
                $str .= "Error number: " .curl_errno($this->ch) ."\n";
		$str .= "Error message: " .curl_error($this->ch)."\n";
            
                json_encode($str);
            }
            return false;
	}else{
        	return $result;
	}

        
    }
    public function DELETE($url){
        curl_setopt($this->ch, CURLOPT_URL,$url);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE"); 
        $result = curl_exec($this->ch);
        
        if(curl_errno($this->ch)){
            if($this->debug){
		$str = "Error Occured in Curl\n";
                $str .= "Error number: " .curl_errno($this->ch) ."\n";
		$str .= "Error message: " .curl_error($this->ch)."\n";
            
                json_encode($str);
            }
            return false;
	}else{
        	return $result;
	}

        
    }
              
    public function close() {
        curl_close($this->ch);
        
    }
    
    
    
}

?>
