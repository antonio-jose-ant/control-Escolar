<?php
namespace App\services\login;
use App\mapping\login_attempts;
use App\mapping\SqlComands;
use App\Config\Debuger;
class LoginAttemptRepository extends login_attempts
{
    private $Debuger;
    public function __construct(private \PDO $pdo, $debuger = null)
    {
        // $this->Debuger = $debuger;
    }
    public function registrarIntento(string $usuario, string $ip, string $ua, string $res, string $razon)
    {

        $params = [
            'usuario' => $usuario,
            'ip' => $ip,
            'user_agent' => $ua,
            'resultado' => $res,
            'razon_fallo' => $razon
        ];
        $sql = SqlComands::insert($this->nameTable, ['usuario', 'ip', 'user_agent', 'resultado', 'razon_fallo']);
        // $this->Debuger->setInfoDebug('insert:SQL', $sql);
        return $this->pdo->prepare($sql)->execute($params);
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