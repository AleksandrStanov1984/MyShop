<?php

class ModelToolCurl extends Model
{
    public function request($request_url)
    {

        // server api
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server_api = HTTPS_API;
        } else {
            $server_api = HTTP_API;
        }

        $request_url = $server_api . $request_url;

        // request on server
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $request_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $response = mb_convert_encoding($response, 'utf-8');
        $response = json_decode($response, true);

        return $response;

    }
}