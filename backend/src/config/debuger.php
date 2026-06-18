<?php
namespace App\Config;
class Debuger
{
    private array $info;
    private string $accesModule;
    public function __construct(string $module)
    {
        $this->mapingModules();
        $this->accesModule = $module;
    }
    public function setInfoDebug(string $proces, string $data)
    {
        $this->info[$this->accesModule] = [$proces => $data];
    }
    public function getDataProces(string $proces): array
    {
        return $this->info[$this->accesModule][$proces];
    }
    public function getDataAllmodule(): array
    {
        return $this->info[$this->accesModule];
    }
    public function getDataAll(): array
    {
        return $this->info;
    }
    private function mapingModules()
    {
        $this->info = [
            'IP' => true,
            'LOGIN' => true
        ];

    }
}