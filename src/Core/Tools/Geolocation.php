<?php

namespace AnexusPHP\Core\Tools;

class Geolocation
{
    public static function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public static function metersToHuman($meters)
    {
        $meters = doubleval($meters);
        $kilometers = floor(($meters / doubleval(1000)));
        if ($kilometers < 1) {
            $kilometers = doubleval(0);
        }
        $meters = abs((($kilometers * doubleval(1000)) - $meters));
        $meters = round($meters, 0);
        return ($kilometers > 0 ? $kilometers . 'km e ' : '') . $meters . ' metros';
    }
}
