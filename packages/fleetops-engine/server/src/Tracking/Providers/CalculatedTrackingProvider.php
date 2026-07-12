<?php

namespace Transitops\FleetOps\Tracking\Providers;

use Transitops\FleetOps\Support\Utils;
use Transitops\FleetOps\Tracking\Contracts\TrackingProviderInterface;
use Transitops\FleetOps\Tracking\TrackingContext;
use Transitops\FleetOps\Tracking\TrackingOptions;
use Transitops\FleetOps\Tracking\TrackingProviderCapabilities;
use Transitops\FleetOps\Tracking\TrackingProviderResult;

class CalculatedTrackingProvider implements TrackingProviderInterface
{
    public function key(): string
    {
        return 'calculated';
    }

    public function capabilities(): TrackingProviderCapabilities
    {
        return new TrackingProviderCapabilities();
    }

    public function canTrack(TrackingContext $context): bool
    {
        return $context->canRoute();
    }

    public function track(TrackingContext $context, TrackingOptions $options): TrackingProviderResult
    {
        $points   = $context->routePoints();
        $distance = 0;
        $legs     = [];

        for ($i = 0; $i < count($points) - 1; $i++) {
            $legDistance = Utils::vincentyGreatCircleDistance($points[$i], $points[$i + 1]);
            $legDuration = $this->durationFromDistance($legDistance, $options);
            $distance += $legDistance;
            $legs[] = [
                'index'                 => $i,
                'distance_m'            => $legDistance,
                'duration_s'            => $legDuration,
                'duration_in_traffic_s' => null,
                'provider'              => $this->key(),
            ];
        }

        return new TrackingProviderResult(
            provider: $this->key(),
            distanceMeters: $distance,
            durationSeconds: $this->durationFromDistance($distance, $options),
            durationInTrafficSeconds: null,
            legs: $legs,
            warnings: ['calculated_route_used'],
            confidence: 'low'
        );
    }

    protected function durationFromDistance(float $distanceMeters, TrackingOptions $options): float
    {
        $metersPerSecond = max($options->defaultVehicleSpeedKph, 1) * 1000 / 3600;

        return round($distanceMeters / $metersPerSecond);
    }
}
