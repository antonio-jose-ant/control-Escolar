<?php
namespace App\mapping;
class ip_blacklist
{
    public $nameTable = 'ip_blacklist';
    public $As = 'blacklist';
    public int $id;
    public string $ip;
    public string $motivo;
    public string $fecha;

}