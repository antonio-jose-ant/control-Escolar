<?php
namespace App\services\ip;
use App\services\ip\IPServices;
class IPController
{
    private $Services;
    public function __construct(private IPServices $IPService)
    {
        $this->Services = $IPService;
    }
    public function countAuthFailed(string $usuario, string $ip)
    {
        return $this->Services->countAuthFailed($usuario, $ip);
    }
    public function IpIsBloqued(string $usuario, string $ip)
    {
        return $this->Services->IpIsBloqued($usuario, $ip);
    }
}