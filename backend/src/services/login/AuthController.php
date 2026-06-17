<?php
namespace App\services\login;
class AuthController
{
    private $Services;
    public function __construct(private AuthService $AuthService)
    {
        $this->Services = $AuthService;
    }
    public function login(string $usuario, string $contraseña)
    {
        $this->Services->auth(
            $usuario,
            $contraseña,
            $_SERVER['HTTP_USER_AGENT']
        );
    }
    public function logout()
    {
        // 1. Obtener el token crudo de la cookie
        $token = $_COOKIE['session_token'] ?? null;
        // Si no hay token, no hay sesión activa que cerrar (o ya fue cerrada)
        if (empty($token)) {
            return true;
        }
        return $this->Services->exit($token);
    }
}