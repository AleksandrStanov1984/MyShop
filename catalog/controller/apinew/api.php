<?php

class ControllerApi extends Controller
{
    protected $status = 500, $body = '';

//    public function __construct()
//    {
//        header('Access-Control-Allow-Origin: *');//{$_SERVER['HTTP_ORIGIN']}
//        header('Access-Control-Allow-Credentials: true');
//        header('Access-Control-Max-Age: 86400');
//        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');
//
//        $rawBody = json_decode($this->request->post);
//        if ($rawBody) $_POST = array_merge($_POST,$rawBody);

//        defined("CACHETIME") or define("CACHETIME", 60);
//    }


    protected function getStatusCodeMessage($status = null): string
    {
        $status = $status ?: $this->status;
        $codes = [
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    protected function sendResponse($content_type = 'application/json')
    {
        header('HTTP/1.1 ' . $this->status . ' ' . $this->getStatusCodeMessage());
        header('Content-type: ' . $content_type);

        $response = ['status' => $this->status, 'body' => $this->body];
        echo json_encode($response);
    }

    protected function successResponse($response)
    {
        $this->body = $response;
        $this->status = 200;
    }

    protected function errorResponse($response, int $status = 500)
    {
        if ($status > 200) {
            $this->body = $response;
            $this->status = $status;
        }
    }
}