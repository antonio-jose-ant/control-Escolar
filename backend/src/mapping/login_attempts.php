<?php
namespace App\mapping;

use DateTime;

class login_attempts
{
    public $nameTable = 'login_attempts';
    public $As = 'intento';
    public int $id;
    public string $usuario;
    public string $ip;
    public string $user_agent;
    public DateTime $fecha;
    public string $resultado;
    public string $razon_fallo;


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