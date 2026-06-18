<?php
namespace App\factory;
use App\Config\Database;
use App\services\ip\IPServices;
use App\services\ip\IPController;
class IpFactory
{
    public static function blockFailedAttempts(string $usuario, string $ip)
    {
        $db = new Database();
        $service = new IPServices($db->getConnection());
        $authController = new IPController($service);
        return $authController->countAuthFailed($usuario, $ip);
    }

    public static function ipBloqued(string $usuario, string $ip)
    {
        $db = new Database();
        $service = new IPServices($db->getConnection());
        $authController = new IPController($service);
        return $authController->IpIsBloqued($usuario, $ip);
    }


}