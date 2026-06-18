<?php
namespace App\mapping;
class IP_TEMPORARILY_BLOCKED
{
    public $nameTable = 'IP_TEMPORARILY_BLOCKED';
    public $As = 'tempBlock';
    public int $id_ip;
    public string $user;
    public string $ip;
    public string $fecha_inicio;
    public string $fecha_fin;
}