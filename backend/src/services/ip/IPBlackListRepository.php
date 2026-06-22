<?php
namespace App\services\ip;
class IPBlackListRepository extends \App\mapping\ip_blacklist
{

    public function __construct(private \PDO $pdo)
    {
        parent::__construct($pdo);
    }
    public function existeIp(string $ip)
    {
        $sql = self::select($this->nameTable, ['IF(COUNT(*) > 0, TRUE, FALSE) AS exist'], ["ip=:ip"]);
        $this->info->setInfo('existeIp:SQL', $sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        // echo json_encode(['sql' => $sql, 'rs' => $row]);
        return $row['exist'];

    }
}
