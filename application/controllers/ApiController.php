<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    // Configurar los encabezados CORS
    protected function setCORSHeaders()
    {
        header("Access-Control-Allow-Origin: http://localhost:3000");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type");
    }

    // Responder con una respuesta JSON
    protected function jsonResponse($status, $message, $data = [])
    {
        $response = ['message' => $message];
        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_status_header($status)
            ->set_output(json_encode($response));
    }
}
