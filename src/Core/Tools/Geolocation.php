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

    public static function isInPolygon()
    {
        $vertices_x = array(37.628134, 37.629867, 37.62324, 37.622424);    // x-coordinates of the vertices of the polygon
        $vertices_y = array(-77.458334, -77.449021, -77.445416, -77.457819); // y-coordinates of the vertices of the polygon
        $points_polygon = count($vertices_x) - 1;  // number vertices - zero-based array
        $longitude_x = $_GET["longitude"];  // x-coordinate of the point to test
        $latitude_y = $_GET["latitude"];    // y-coordinate of the point to test

        if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)) {
            echo "Is in polygon!";
        } else echo "Is not in polygon";


        function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
        {
            $i = $j = $c = 0;
            for ($i = 0, $j = $points_polygon; $i < $points_polygon; $j = $i++) {
                if ((($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
                    ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])))
                    $c = !$c;
            }
            return $c;
        }
    }
}
