<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class USERS extends SqlComands
{
    protected $nameTable = 'USERS';
    protected $As = 'user';
    public $info;
    public function __construct()
    {
        $this->info = new Debuger();
    }
    public function Agregar()
    {

    }
}