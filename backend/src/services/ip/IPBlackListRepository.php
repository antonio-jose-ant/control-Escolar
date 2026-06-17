<?php
namespace App\services\ip;
class IPBlackListRepository
{
    public function __construct(private \PDO $pdo)
    {
    }
    public function insert(string $ip, string $reason)
    {
        $sql = "INSERT INTO IP_BLACKLIST (ip, motivo) VALUES (:ip, :motivo)";
        $params = [
            'ip' => $ip,
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }
    
}
