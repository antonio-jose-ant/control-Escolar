<?php
namespace App\services\login;
use App\mapping\login_attempts;
use App\mapping\SqlComands;
class LoginAttemptRepository extends login_attempts
{
    public function __construct(private \PDO $pdo)
    {
    }
    public function registrarIntento(string $usuario, string $ip, string $ua, string $res, string $razon)
    {

        $params = [
            'usuario' => $usuario,
            'ip' => $ip,
            'user_agent' => $ua,
            'resultado' => $res,
            'razon_fallo' => $razon
        ];
        $sql = SqlComands::insert($this->nameTable, ['usuario', 'ip', 'user_agent', 'resultado', 'razon_fallo']);
        return $this->pdo->prepare($sql)->execute($params);
    }
    public function IntentosFallidos(string $ip, string $usuario, int $time)
    {
        $sql = SqlComands::select(
            $this->nameTable,
            ['count(*)'],
            ["ip=:ip", "usuario=:usuario", "resultado = 'fail'", "fecha >= NOW() - INTERVAL {$time} MINUTE", "DATE(fecha) = CURDATE()"]
        );
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['ip' => $ip, 'usuario' => $usuario]);
    }

}