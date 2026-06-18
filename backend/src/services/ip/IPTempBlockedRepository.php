<?php
namespace App\services\ip;
use App\mapping\SqlComands;
use App\Config\Debuger;
class IPTempBlockedRepository extends \App\mapping\IP_TEMPORARILY_BLOCKED
{
    public function __construct(private \PDO $pdo)
    {
    }
    
    public function existeIp(string $ip, string $usuario)
    {
        $sql = SqlComands::select($this->nameTable, ['IF(COUNT(*) > 0, TRUE, FALSE) AS exist'], ["ip=:ip", "user=:usuario", "fecha_fin >= NOW()"]);
        $this->info->setInfo('existeIp:SQL', $sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip, 'usuario' => $usuario]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['exist'];
    }
}
