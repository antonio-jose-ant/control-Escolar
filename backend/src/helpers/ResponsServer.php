<?php
namespace App\helpers;

class ResponsServer
{
    /**
     * Respuesta exitosa
     */
    public function success($data = null, int $codeInternal = 1, int $code = 200, array $info = [])
    {
        $this->sendJson([
            'status' => 'success',
            'ok' => true,
            'code' => $codeInternal,
            'data' => $data,
            'info' => $info
        ], $code);
    }

    /**
     * Respuesta de error controlado
     */
    public function error(string $message, int $codeInternal = -1, int $code = 400, array $info = [])
    {
        $this->sendJson([
            'status' => 'error',
            'ok' => false,
            'code' => $codeInternal,
            'message' => $message,
            'httpError' => $code,
            'info' => $info
        ], $code);
    }

    /**
     * Respuesta general
     */
    private function sendJson(array $payload, int $httpCode)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json");
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
