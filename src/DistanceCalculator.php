<?php
/**
 * Created by PhpStorm.
 * User: Mateusz
 * Date: 24.04.2016
 * Time: 23:32
 */

namespace MateuszBlaszczyk\GpxToJson;


class DistanceCalculator
{
    public function countDistanceBetween2Trackpoints(Trackpoint $geolocation1, Trackpoint $geolocation2, $unit = 'K')
    {
        $theta = $geolocation1->longitude - $geolocation2->longitude;
        if ($theta == 0 && $geolocation1->latitude - $geolocation2->latitude == 0) {
            return 0;
        }

        $dist = sin(deg2rad($geolocation1->latitude)) * sin(deg2rad($geolocation2->latitude)) + cos(deg2rad($geolocation1->latitude)) * cos(deg2rad($geolocation2->latitude)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit === 'K') {
            return ($miles * 1.609344);
        } else if ($unit === 'N') {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}