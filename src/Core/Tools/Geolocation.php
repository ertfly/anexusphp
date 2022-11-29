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

    public static function isInPolygon($lat, $lng, array $verticesY, array $verticesX)
    {
        $pointsPolygon = count($verticesX) - 1;  // number vertices - zero-based array
        $latitudeY = $lat;    // y-coordinate of the point to test
        $longitudeX = $lng;  // x-coordinate of the point to test

        $i = $j = $c = 0;
        for ($i = 0, $j = $pointsPolygon; $i < $pointsPolygon; $j = $i++) {
            if ((($verticesY[$i]  >  $latitudeY != ($verticesY[$j] > $latitudeY)) &&
                ($longitudeX < ($verticesX[$j] - $verticesX[$i]) * ($latitudeY - $verticesY[$i]) / ($verticesY[$j] - $verticesY[$i]) + $verticesX[$i])))
                $c = !$c;
        }
        return $c;
    }
}
