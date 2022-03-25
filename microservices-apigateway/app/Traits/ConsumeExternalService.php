<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumeExternalService {

    /**
     * Send a request to any service
     * @return string
     */
    public function performRequest($method, $requestUrl, $formParams = [], $headers = []){

        // Create an instance of guzzle
        $client = new Client([
            'base_uri' => $this->baseUri
        ]);

        // Add authorization header
        if(isset($this->secret)){
            $headers['Authorization'] = "{$this->secret}";
        }

        // Make a request with configuration
        $response = $client->request($method, $requestUrl, [
            'form_params' => $formParams,
            'headers' => $headers
        ]);

        // Return a response
        return $response->getBody()->getContents();
    }
}
