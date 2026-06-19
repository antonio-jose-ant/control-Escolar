<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class login_attempts extends SqlComands
{
    public $nameTable = 'login_attempts';
    public $As = 'intento';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }

    public function Agregar(string $usuario, string $ip, string $ua, string $res, string $razon)
    {

        $params = [
            'usuario' => $usuario,
            'ip' => $ip,
            'user_agent' => $ua,
            'resultado' => $res,
            'razon_fallo' => $razon
        ];
        $sql = self::INSERT($this->nameTable, ['usuario', 'ip', 'user_agent', 'resultado', 'razon_fallo']);
        // $this->Debuger->setInfoDebug('insert:SQL', $sql);
        return $this->pdo->prepare($sql)->execute($params);
    }
}