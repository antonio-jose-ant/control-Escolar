<?php
namespace App\services\ip;
use App\services\login\LoginAttemptRepository;
use App\services\ip\IPBlockedRepository;
use App\services\ip\IPTempBlockedRepository;
use App\services\ip\IPBlackListRepository;
class IPServices
{
    private $blocked;
    private $tempBlocked;
    private $backList;
    private $LoginAttemp;
    private $Debuger;
    public function __construct(private \PDO $conexion)
    {
        $this->blocked = new IPBlockedRepository($conexion);
        $this->tempBlocked = new IPTempBlockedRepository($conexion);
        $this->backList = new IPBlackListRepository($conexion);
        $this->LoginAttemp = new LoginAttemptRepository($conexion);
    }
    public function IpIsBloqued(string $usuario, string $ip)
    {
        if ($this->backList->existeIp($ip)) {
            return true;
        }
        if ($this->blocked->existeIp($ip)) {

            return true;
        }
        if ($this->tempBlocked->existeIp($ip, $usuario)) {

            return true;
        }
        $this->setInfoDebug('backList:existeIp', $this->backList->getInfoDebug());
        $this->setInfoDebug('blocked:existeIp', $this->blocked->info->getInfo());
        $this->setInfoDebug('tempBlocked:existeIp', $this->tempBlocked->info->getInfo());
        return false;
    }
    public function countAuthFailed(string $usuario, string $ip)
    {
        $rs = $this->LoginAttemp->IntentosFallidos($ip, $usuario, 5);
        $this->setInfoDebug('countAuthFailed:5', $rs);
        if ($rs == 5) {
            $this->tempBlocked->Agregar($ip, $usuario);
            $this->setInfoDebug('tempBlocked:insert', $this->LoginAttemp->getInfoDebug());
            return true;
        }
        if ($rs >= 15) {
            $this->blocked->Agregar($ip, "exeso de Intentos fallidos");
            $this->setInfoDebug('blocked:insert', $this->LoginAttemp->getInfoDebug());
            return true;
        }
        $this->setInfoDebug('sin bloqueo:insert', $this->LoginAttemp->getInfoDebug());

        return false;
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