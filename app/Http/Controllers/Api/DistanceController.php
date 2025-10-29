<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DistanceCalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DistanceController extends Controller
{
    public function __construct(private readonly DistanceCalculatorService $service) {}

    /**
     * Calculate distance between two coordinates
     */
    public function calculate(Request $request): JsonResponse
    {
        $request->validate([
            'origin_lat' => ['required', 'numeric', 'between:-90,90'],
            'origin_lon' => ['required', 'numeric', 'between:-180,180'],
            'dest_lat' => ['required', 'numeric', 'between:-90,90'],
            'dest_lon' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $distance = $this->service->calculateDistance(
            $request->origin_lat,
            $request->origin_lon,
            $request->dest_lat,
            $request->dest_lon
        );

        return response()->json([
            'distance_km' => $distance,
            'distance_miles' => $this->service->kmToMiles($distance),
        ]);
    }

    /**
     * Calculate trip estimate with cost
     */
    public function estimate(Request $request): JsonResponse
    {
        $request->validate([
            'origin_lat' => ['required', 'numeric', 'between:-90,90'],
            'origin_lon' => ['required', 'numeric', 'between:-180,180'],
            'dest_lat' => ['required', 'numeric', 'between:-90,90'],
            'dest_lon' => ['required', 'numeric', 'between:-180,180'],
            'rate_per_km' => ['required', 'numeric', 'min:0'],
            'fixed_rate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $estimate = $this->service->calculateTripEstimate(
            $request->origin_lat,
            $request->origin_lon,
            $request->dest_lat,
            $request->dest_lon,
            $request->rate_per_km,
            $request->fixed_rate ?? 0
        );

        return response()->json($estimate);
    }
}
