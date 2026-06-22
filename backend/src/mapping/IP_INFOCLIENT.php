<?php
namespace App\mapping;
use App\mapping\SqlComands;
use App\Config\Debuger;
class IP_INFOCLIENT extends SqlComands
{
    protected $nameTable = 'IP_INFOCLIENT';
    protected $As = 'IPData';
    public $info;
    public $warning;
    public $errors;
    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }
    public function mappingCols(array $cols): array
    {
        $colums = [
            "id" => ['AS' => "IdDataIp", 'type' => "int", "PK" => true],
            "ip" => ['AS' => "Ip", 'type' => "string", "INDEX" => true, 'null' => false],
            "fecha" => ['AS' => "fecha", 'type' => "date"],
            "user_agent" => ['AS' => "Navegador", 'type' => "string", 'null' => true],
            "country" => ['AS' => "Pais", 'type' => "string", 'null' => false],
            "region" => ['AS' => "Estado", 'type' => "string", 'null' => false],
            "city" => ['AS' => "ciudad", 'type' => "string", 'null' => false],
            "latitude" => ['AS' => "Lat", 'type' => "string", 'null' => false],
            "longitude" => ['AS' => "Lon", 'type' => "string", 'null' => false],
        ];
        return $colums;
    }
    public function Agregar(string $ip, string $Navegador, string $Pais, string $Estado, string $ciudad, string $Lat, string $Lon)
    {
        $cols = ["ip", "Navegador", "Pais", "Estado", "ciudad", "Lat", "Lon"];

        $sql = SqlComands::INSERT($this->nameTable, ['ip', 'fecha_inicio', 'fecha_fin', 'motivo']);
        $this->info->setInfo('insert:SQL', $sql);
        $params = [
            'ip' => $ip,
            'fecha_inicio' => date('Y-m-d H:i:s'),
            'fecha_fin' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'motivo' => ""
        ];
        return $this->pdo->prepare($sql)->execute($params);
    }

}