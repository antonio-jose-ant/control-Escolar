<?php
namespace App\factory;
use App\Config\Database;
use App\services\ip\IPServices;
use App\services\ip\IPController;

class IpFactory
{
    private $Debuger;
    public function blockFailedAttempts(string $usuario, string $ip)
    {
        $db = new Database();
        $service = new IPServices($db->getConnection());
        $IPController = new IPController($service);
        $rs = $IPController->countAuthFailed($usuario, $ip);
        $this->setInfoDebug('blockFailedAttempts', $IPController->getInfoDebug());
        return $rs;
    }

    public function ipBloqued(string $usuario, string $ip)
    {
        $db = new Database();
        $service = new IPServices($db->getConnection());
        $IPController = new IPController($service);
        $rs = $IPController->IpIsBloqued($usuario, $ip);
        $this->setInfoDebug('ipBloqued', $IPController->getInfoDebug());
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