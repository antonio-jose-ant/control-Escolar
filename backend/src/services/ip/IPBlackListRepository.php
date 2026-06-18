<?php
namespace App\services\ip;
use App\mapping\SqlComands;
class IPBlackListRepository extends \App\mapping\ip_blacklist
{
    private $Debuger;

    public function __construct(private \PDO $pdo)
    {
    }
    public function insert(string $ip, string $reason)
    {
        $sql = SqlComands::insert($this->nameTable, ['ip', 'motivo']);
        $this->setInfoDebug('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }

    public function existeIp(string $ip)
    {
        $sql = SqlComands::select($this->nameTable, ['IF(COUNT(*) > 0, TRUE, FALSE) AS exist'], ["ip=:ip"]);
        $this->setInfoDebug('existeIp:SQL', $sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        // echo json_encode(['sql' => $sql, 'rs' => $row]);
        return $row['exist'];

    }
    public function getInfoDebug()
    {
        return $this->Debuger;
    }
    private function setInfoDebug($proces, $info)
    {
        $this->Debuger[$proces] = $info;
    }
}
