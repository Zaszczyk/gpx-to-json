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
        $geolocation1->longitude = round($geolocation1->longitude, 6);
        $geolocation1->latitude = round($geolocation1->latitude, 6);
        $geolocation2->longitude = round($geolocation2->longitude, 6);
        $geolocation2->latitude = round($geolocation2->latitude, 6);

        $theta = $geolocation1->longitude - $geolocation2->longitude;
        if ($theta < 0.0000001) {
            $theta = round($geolocation1->longitude - $geolocation2->longitude, 5);
        }

        if ($theta == 0 && $geolocation1->latitude - $geolocation2->latitude == 0) {
            return 0;
        }

        $dist = sin(deg2rad($geolocation1->latitude)) * sin(deg2rad($geolocation2->latitude)) + cos(deg2rad($geolocation1->latitude)) * cos(deg2rad($geolocation2->latitude)) * cos(deg2rad($theta));
        if (1.0 === $dist) {
            return 0;
        }
        $dist = acos(min(max($dist, -1.0), 1.0));
        if (0.0 === $dist) {
            return 0;
        }
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
