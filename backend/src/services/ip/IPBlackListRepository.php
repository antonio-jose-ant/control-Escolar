<?php
namespace App\services\ip;
use App\mapping\SqlComands;
use AppendIterator;
class IPBlackListRepository extends \App\mapping\ip_blacklist
{
    public function __construct(private \PDO $pdo)
    {
    }
    public function insert(string $ip, string $reason)
    {
        $sql = SqlComands::insert($this->nameTable, ['ip', 'motivo']);
        $params = [
            'ip' => $ip,
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
