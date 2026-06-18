<?php
namespace App\services\ip;
use App\mapping\SqlComands;
use AppendIterator;
class IPBlockedRepository extends \App\mapping\IP_BLOCKED
{
    public function __construct(private \PDO $pdo)
    {
    }
    public function insert(string $ip, string $reason)
    {
        $sql = SqlComands::insert($this->nameTable, ['ip', 'fecha_inicio', 'fecha_fin', 'motivo']);
        $params = [
            'ip' => $ip,
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }

    public function existeIp(string $ip)
    {
        $sql = SqlComands::select($this->nameTable, ['count(*) as exist'], ["ip=:ip"]);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['exist'];
    }
}
