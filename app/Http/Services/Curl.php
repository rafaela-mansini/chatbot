<?php

namespace App\Http\Services;

class Curl {

    protected $curlObject;
    protected $endpoint;

    public function __construct(String $endpoint){
        $this->endpoint = $endpoint;
        $this->curlObject = curl_init();
    }

    public function get(){
        curl_setopt_array($this->curlObject, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $this->endpoint
        ]);
        $result = json_decode(curl_exec($this->curlObject), true);
        curl_close($this->curlObject);
        return $result;
    }
}