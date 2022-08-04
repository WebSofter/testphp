<?php
namespace App;

Class HttpRequest implements IHttpRequest{
    
    const GET = 'GET';
    //
    //The IP address of the proxy you want to send
    //your request through.
    public $proxy_ip = null;
    //The port that the proxy is listening on.
    public $proxy_port = null;
    //The username for authenticating with the proxy.
    public $proxy_user = null;
    //The password for authenticating with the proxy.
    public $proxy_password = null;
    //
    private $url = null;
    private $data = [];
    private $contentType = 'application/json';
    //
    private $headers = [];
    private $response = null;
    private $ch = null;
    public function __construct($url, $data, $contentType = 'application/json'){
        $this->url = $url;
        $this->data = $data;
        $this->contentType = $contentType;
        $this->headers = array(
            "Content-Type: {$contentType}",
            "Accept: {$contentType}",
        );
        $this->ch = curl_init();
    }
    public function __desstruct(){
        curl_close($this->ch);
    }

    function send($url, $data, $contentType = 'application/json', $has_out_header = FALSE){
        $params = http_build_query($data);
        $src = $url."?".$params;
        //Proxy settings
        if(!is_null($this->proxy_ip) && !is_null($this->proxy_port ) && !is_null($this->proxy_user) && !is_null($this->proxy_password)) {
            curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL , TRUE);
            curl_setopt($this->ch, CURLOPT_PROXY, $this->proxy_ip);
            curl_setopt($this->ch, CURLOPT_PROXYPORT, $this->proxy_port);
            curl_setopt($this->ch, CURLOPT_PROXYUSERPWD, "{$this->proxy_user}:{$this->proxy_password}");
        }
        //Other options
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($this->ch, CURLOPT_URL, $src);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 80);
        curl_setopt($this->ch, CURLOPT_HEADER, $has_out_header);
        //Exec
        $this->response = curl_exec($this->ch);
            
        if(curl_error($this->ch)){
            //General request errors
            return 'Request Error:' . curl_error($this->ch);
        }else{
            return $this->response;
        }
           
        curl_close($this->ch);
    }
    public function getJson() {
        $this->send($this->url, $this->data, $this->contentType);
        return json_encode($this->response);
    }
    public function getString() {
        $this->send($this->url, $this->data, $this->contentType);
        return strip_tags($this->response);
    }
    public function getRaw() {
        $this->send($this->url, $this->data, $this->contentType);
        return $this->response;
    }
    public function getHeader(string $name = null) {
        $this->send($this->url, $this->data, $this->contentType, TRUE);
        $out = preg_split('/(\r?\n){2}/', $this->response, 2);
        $headers = $out[0];
        $headersArray = preg_split('/\r?\n/', $headers);
        $headersArray = array_map(function($h) {
            return preg_split('/:\s{1,}/', $h, 2);
        }, $headersArray);
        
        $tmp = [];
        foreach($headersArray as $h) {
            $tmp[strtolower($h[0])] = isset($h[1]) ? $h[1] : $h[0];
        }
        $headersArray = $tmp; $tmp = null;
        return $headersArray;
    }
}

?>