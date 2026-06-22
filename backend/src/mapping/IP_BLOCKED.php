<?php
namespace App\mapping;
use App\mapping\SqlComands;
use App\Config\Debuger;
class IP_BLOCKED extends SqlComands
{
    protected $nameTable = 'IP_BLOCKED';
    protected $As = 'IPBlock';
    public $info;
    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }
    public function Agregar(string $ip, string $reason)
    {
        $sql = SqlComands::INSERT($this->nameTable, ['ip', 'fecha_inicio', 'fecha_fin', 'motivo']);
        $this->info->setInfo('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }

}