<?php

namespace App\Services;

/**
 * Class DistanceCalculator
 * @package App\Services
 */
class DistanceCalculator
{
    /** @var array $centralCoords */
    private $centralCoords;

    const EARTH_RADIUS_KM = 6371;
    const PI = 3.14;
    const LINE = 180;

    /**
     * DistanceCalculator constructor.
     */
    public function __construct()
    {
        /* Retrieve config */
        $this->centralCoords = config('app.CENTRAL_COORDS');
    }

    /**
     * @param array $coords
     * @return float
     */
    public function get(array $coords)
    {
        return $this->getEarthKmDistance(
            $this->centralCoords['lat'],
            $this->centralCoords['lng'],
            $coords['lat'],
            $coords['lng']
        );
    }

    /**
     * @param double $latL
     * @param double $lngL
     * @param double $latR
     * @param double $lngR
     * @return double
     */
    private function getEarthKmDistance($latL, $lngL, $latR, $lngR) {
        $earthRadius = self::EARTH_RADIUS_KM;
        $dLat = $this->deg2rad($latR-$latL);
        $dLon = $this->deg2rad($lngR-$lngL);
        $a = sin($dLat/2) * sin($dLat/2) + cos($this->deg2rad($latL)) * cos($this->deg2rad($latR)) * sin($dLon/2) * sin($dLon/2);
        $b = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $b; // Distance in km
    }

    private function deg2rad($deg) {
        return $deg * (self::PI/self::LINE);
    }
}

