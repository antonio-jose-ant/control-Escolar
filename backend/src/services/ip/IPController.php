<?php
namespace App\services\ip;
use App\services\ip\IPServices;
class IPController
{
    private $Debuger;
    private $Services;
    public function __construct(private IPServices $IPService)
    {
        $this->Services = $IPService;
    }
    public function countAuthFailed(string $usuario, string $ip)
    {
        $rs = $this->Services->countAuthFailed($usuario, $ip);
        $this->setInfoDebug('countAuthFailed', $this->Services->getInfoDebug());
        return $rs;
    }
    public function IpIsBloqued(string $usuario, string $ip)
    {
        $rs = $this->Services->IpIsBloqued($usuario, $ip);
        $this->setInfoDebug('IpIsBloqued', $this->Services->getInfoDebug());
        return $rs;
    }
    public function getInfoDebug()
    {
        return $this->Debuger;
    }
    private function setInfoDebug($proces, $info)
    {
        $this->Debuger[$proces] = $info;
    }
}