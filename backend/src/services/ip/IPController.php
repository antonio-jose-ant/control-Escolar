<?php
namespace App\services\ip;
use App\services\ip\IPServices;
class IPController
{
    private $Services;
    public function __construct(private IPService $IPService)
    {
        $this->Services = $IPService;
    }
    public function countAuthFailed(string $usuario, string $contraseña){

    }
    public function IpIsBloqued(string $usuario, string $ip)
    {

    }
}