<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class ip_blacklist extends SqlComands
{
    protected $nameTable = 'ip_blacklist';
    protected $As = 'blacklist';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }
    public function Agregar(string $ip, string $reason)
    {
        $sql = SqlComands::insert($this->nameTable, ['ip', 'motivo']);
        $this->info->setInfo('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }
}