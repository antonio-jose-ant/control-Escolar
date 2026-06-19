<?php
namespace App\services\ip;

use App\mapping\SqlComands;
class IPBlockedRepository extends \App\mapping\IP_BLOCKED
{
    public function __construct(private \PDO $pdo)
    {
        parent::__construct($pdo);
    }

    public function existeIp(string $ip)
    {
        $sql = SqlComands::select($this->nameTable, ['IF(COUNT(*) > 0, TRUE, FALSE) AS exist'], ["ip=:ip", "fecha_fin >= NOW()"]);
        $this->info->setInfo('existeIp:SQL', $sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        // echo json_encode(['sql' => $sql, 'rs' => $row]);
        return $row['exist'];
        // return 1;
    }
}
