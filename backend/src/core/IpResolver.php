<?php
namespace App\core;
class IpResolver
{
    private array $info;
    function get_client_ip()
    {
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_list = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $ip = trim($ip_list[0]); // La primera IP suele ser la del cliente original

            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                $this->setInfoDebug('HTTP_X_FORWARDED_FOR', $ip);
                return $ip;
            }
        }
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            if (filter_var($_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
                $this->setInfoDebug('HTTP_CF_CONNECTING_IP', $_SERVER['HTTP_CF_CONNECTING_IP']);
                return $_SERVER['HTTP_CF_CONNECTING_IP'];
            }
        }
        $this->setInfoDebug('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']);
        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    public function getInfoDebug(): array
    {
        return $this->info;
    }
    private function setInfoDebug(string $position, string $data)
    {
        $this->info[$position] = $data;
    }
}


