<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
/**
 * ORM tabla ip_blacklist
 *   - Eccargada de bloquear ip de forma permanente 
 */
class ip_blacklist extends SqlComands
{
    protected $nameTable = 'ip_blacklist';
    protected $As = 'blacklist';
    public $info;

    /**
     * Summary of __construct
     * @param \PDO $pdo
     */
    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }


    public function mappingCols(array $cols)
    {
        $colums = [
            "id" => ['AS' => "IdBlcList", 'type' => "int", "PK" => true],
            "ip" => ['AS' => "Ip", 'type' => "string"],
            "fecha" => ['AS' => "Bloqueada", 'type' => "date"],
            "motivo" => ['AS' => "Razon", 'type' => "string"]
        ];
    }
    public function Agregar(string $ip, string $reason)
    {
        $sql = SqlComands::insert($this->nameTable, ['ip', 'motivo']);
        $this->info->setInfo('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'motivo' => $reason
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }
}