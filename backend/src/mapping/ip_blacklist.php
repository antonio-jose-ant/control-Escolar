<?php
namespace App\mapping;
use App\Config\Debuger;
use App\mapping\SqlComands;
class ip_blacklist extends SqlComands
{
    public $nameTable = 'ip_blacklist';
    public $As = 'blacklist';
    public $info;

    public function __construct(private \PDO $pdo)
    {
        $this->info = new Debuger();
    }

}