<?php
namespace App\mapping;
use App\mapping\SqlComands;
use App\Config\Debuger;
class IP_TEMPORARILY_BLOCKED extends SqlComands
{
    public $nameTable = 'IP_TEMPORARILY_BLOCKED';
    public $As = 'tempBlock';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }
    public function Agregar(string $ip, string $usuario)
    {
        $sql = SqlComands::INSERT($this->nameTable, ['user', 'ip', 'fecha_inicio', 'fecha_fin']);
        $this->info->setInfo('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'user' => $usuario,
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }
}