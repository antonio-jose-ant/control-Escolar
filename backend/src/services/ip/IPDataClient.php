<?php
namespace App\services\ip;
class IPDataClient extends \App\mapping\IP_INFOCLIENT
{

    public function __construct(private \PDO $pdo)
    {
        parent::__construct($pdo);
    }
    
}
