<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class login_attempts extends SqlComands
{
    public $nameTable = 'login_attempts';
    public $As = 'intento';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }

    /**
     * Summary of getColumns
     * @param array $columns
     * @return string
     */
    public function getColumns(bool $allColumns, array $columns)
    {
        if ($allColumns) {
            return "*";
        }
        $cols = [
            'id' => false,
            'usuario' => false,
            'ip' => false,
            'user_agent' => false,
            'fecha' => false,
            'resultado' => false,
            'razon_fallo' => false
        ];
        $cols = array_merge($cols, $columns);

        $sqlcols = [];
        foreach ($cols as $key => $value) {
            if ($value) {
                $sqlcols[] = "{$this->As}.{$key}";
            }
        }
        $sql = implode(',', $sqlcols);
        return $sql;
    }
}