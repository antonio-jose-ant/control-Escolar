<?php
namespace App\Config;
class Debuger
{
    private $Debuger;
    public function getInfo()
    {
        return $this->Debuger;
    }
    public function setInfo($proces, $info)
    {
        $this->Debuger[$proces] = $info;
    }
}