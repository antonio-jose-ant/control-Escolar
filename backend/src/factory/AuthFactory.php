<?php
namespace App\factory;
use App\Config\Database;
use App\services\login\AuthService;
use App\services\login\AuthController;
class AuthFactory
{
    public static function login(string $user, string $pass)
    {
        $db = new Database();
        $service = new AuthService($db->getConnection());
        $authController = new AuthController($service);
        $authController->login($user, $pass);
    }

    public static function logout()
    {
        $db = new Database();
        $service = new AuthService($db->getConnection());
        $authController = new AuthController($service);
        $authController->logout();
    }


}