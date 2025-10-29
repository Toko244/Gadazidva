<?php

namespace App\Services;

class DistanceCalculatorService
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371; // Earth's radius in kilometers

        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return round($distance, 2);
    }

    /**
     * Calculate distance and estimated cost
     */
    public function calculateTripEstimate(
        float $originLat,
        float $originLon,
        float $destLat,
        float $destLon,
        float $ratePerKm,
        float $fixedRate = 0
    ): array {
        $distance = $this->calculateDistance($originLat, $originLon, $destLat, $destLon);
        
        $distanceCost = $distance * $ratePerKm;
        $totalCost = $distanceCost + $fixedRate;

        return [
            'distance_km' => $distance,
            'rate_per_km' => $ratePerKm,
            'fixed_rate' => $fixedRate,
            'distance_cost' => round($distanceCost, 2),
            'total_cost' => round($totalCost, 2),
            'estimated_duration_minutes' => $this->estimateDuration($distance),
        ];
    }

    /**
     * Estimate trip duration based on distance
     * Assumes average speed of 60 km/h
     */
    protected function estimateDuration(float $distanceKm): int
    {
        $averageSpeedKmh = 60;
        $hours = $distanceKm / $averageSpeedKmh;
        return (int) round($hours * 60); // Convert to minutes
    }

    /**
     * Convert kilometers to miles
     */
    public function kmToMiles(float $km): float
    {
        return round($km * 0.621371, 2);
    }

    /**
     * Convert miles to kilometers
     */
    public function milesToKm(float $miles): float
    {
        return round($miles * 1.60934, 2);
    }
}
