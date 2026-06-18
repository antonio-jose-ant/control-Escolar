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
        return false;
    }
    public function countAuthFailed(string $usuario, string $ip)
    {
        if ($this->LoginAttemp->IntentosFallidos($ip, $usuario, 5) == 5) {
            $this->tempBlocked->insert($ip, $usuario);
            return true;
        }
        if ($this->LoginAttemp->IntentosFallidos($ip, $usuario, 15)) {
            $this->blocked->insert($ip, "exeso de Intentos fallidos");
            return true;
        }
        return false;
    }

}