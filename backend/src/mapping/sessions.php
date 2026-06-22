<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class SESSIONS extends SqlComands
{
    protected $nameTable = 'sessions';
    protected $As = 'tempBlock';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }
    public function Agregar(int $id, string $tokenHash, string $ip, string $ua, string $expires)
    {
        $sql = self::INSERT($this->nameTable, ['user_id', 'token_hash', 'ip', 'user_agent', 'expires_at']);
        $this->info->setInfo('sessions:Agregar',$sql);
        return $this->pdo->prepare($sql)->execute([
            'user_id' => $id,
            'token_hash' => $tokenHash,
            'ip' => $ip,
            'user_agent' => $ua,
            'expires_at' => $expires
        ]);
    }
    public function Eliminar(string $tokenHash){
        $sql =self::DELETE($this->nameTable,['token_hash = :tokenHash']); 
        $params = ['tokenHash' => $tokenHash];
        return $this->pdo->prepare($sql)->execute($params);
    }
}