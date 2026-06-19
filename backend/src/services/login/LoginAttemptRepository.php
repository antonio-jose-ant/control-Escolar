<?php
namespace App\services\login;
use App\mapping\login_attempts;
use App\mapping\SqlComands;
class LoginAttemptRepository extends login_attempts
{
    private $Debuger;
    public function __construct(private \PDO $pdo, $debuger = null)
    {
        // $this->Debuger = $debuger;
    }
    public function IntentosFallidos(string $ip, string $usuario, int $time)
    {
        $sql = SqlComands::select(
            $this->nameTable,
            ['count(*) as total'],
            ["ip=:ip", "usuario=:usuario", "resultado <> 'success'", "fecha >= NOW() - INTERVAL {$time} MINUTE", "DATE(fecha) = CURDATE()"]
        );
        $this->setInfoDebug('IntentosFallidos:SQL', $sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['ip' => $ip, 'usuario' => $usuario]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $row['total'];
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