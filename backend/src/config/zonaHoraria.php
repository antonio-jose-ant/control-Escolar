<?php

namespace App\Config;

use DateTime;
use DateTimeZone;

class ZonaHoraria
{
    private static string $timezone = 'UTC';

    public static function configurar(string $timezone = 'UTC'): void
    {
        self::$timezone = $timezone;
        date_default_timezone_set($timezone);
    }

    public static function obtenerZonaHoraria(): string
    {
        return self::$timezone;
    }

    public static function ahora(): string
    {
        return date('Y-m-d H:i:s');
    }

    public static function fechaActual(): string
    {
        return date('Y-m-d');
    }

    public static function horaActual(): string
    {
        return date('H:i:s');
    }

    public static function crearDateTime(
        ?string $fecha = null
    ): DateTime {

        return new DateTime(
            $fecha ?? 'now',
            new DateTimeZone(self::$timezone)
        );
    }

    public static function convertirZonaHoraria(
        string $fecha,
        string $origen,
        string $destino,
        string $formato = 'Y-m-d H:i:s'
    ): string {

        $date = new DateTime(
            $fecha,
            new DateTimeZone($origen)
        );

        $date->setTimezone(
            new DateTimeZone($destino)
        );

        return $date->format($formato);
    }

    public static function timestamp(): int
    {
        return time();
    }
}