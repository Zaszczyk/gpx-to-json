<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 24.04.2016
 * Time: 23:32
 */

namespace MateuszBlaszczyk\GpxToJson;


class ValueTransformer
{
    protected $gpsAccuracy = 6;

    protected $distanceAccuracy = 5;

    protected $altitudeAccuracy = 2;

    protected $timestampAccuracy = 0;

    public function substrGPSCoordinate($value)
    {
        $dotPos = strpos($value, '.');

        if (!$dotPos) {
            return $value;
        }

        return substr($value, 0, $dotPos + $this->gpsAccuracy + 1);
    }

    public function roundAltitude($value)
    {
        return round($value, $this->altitudeAccuracy);
    }

    public function roundTimestamp($value)
    {
        return round($value, $this->timestampAccuracy);
    }

    public function roundDistanceMetersToKilometers($value)
    {
        return $this->roundDistance($value / 1000);
    }

    public function roundDistance($value)
    {
        return round($value, $this->distanceAccuracy);
    }

    public function transformTime($value)
    {
        if (!$value) {
            return null;
        }
        return strtotime($value);
    }

}