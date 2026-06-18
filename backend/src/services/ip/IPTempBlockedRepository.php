<?php
namespace App\services\ip;
use App\mapping\SqlComands;
use AppendIterator;
class IPTempBlockedRepository extends \App\mapping\IP_TEMPORARILY_BLOCKED
{
    public function __construct(private \PDO $pdo)
    {
    }
    public function insert(string $ip, string $usuario)
    {
        $sql = SqlComands::insert($this->nameTable, ['user', 'ip', 'fecha_inicio', 'fecha_fin']);
        $params = [
            'ip' => $ip,
            'user' => $usuario,
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }

    public function existeIp(string $ip, string $usuario)
    {
        $sql = SqlComands::select($this->nameTable, ['count(*) as exist'], ["ip=:ip", "user=:usuario", "fecha_fin >= NOW()"]);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip, 'usuario' => $usuario]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['exist'];
    }
}
