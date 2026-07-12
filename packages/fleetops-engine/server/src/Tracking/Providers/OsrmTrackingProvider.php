<?php

namespace Transitops\FleetOps\Tracking\Providers;

use Transitops\FleetOps\Support\OSRM;
use Transitops\FleetOps\Tracking\Contracts\TrackingProviderInterface;
use Transitops\FleetOps\Tracking\TrackingContext;
use Transitops\FleetOps\Tracking\TrackingOptions;
use Transitops\FleetOps\Tracking\TrackingProviderCapabilities;
use Transitops\FleetOps\Tracking\TrackingProviderResult;
use Illuminate\Support\Arr;

class OsrmTrackingProvider implements TrackingProviderInterface
{
    public function key(): string
    {
        return 'osrm';
    }

    public function capabilities(): TrackingProviderCapabilities
    {
        return new TrackingProviderCapabilities(perLegEta: true, routeGeometry: true);
    }

    public function canTrack(TrackingContext $context): bool
    {
        return $context->canRoute();
    }

    public function track(TrackingContext $context, TrackingOptions $options): TrackingProviderResult
    {
        $response = OSRM::getRouteFromPoints($context->routePoints(), [
            'overview'    => 'full',
            'geometries'  => 'polyline',
            'steps'       => 'false',
            'annotations' => 'false',
        ]);

        if (data_get($response, 'code') !== 'Ok') {
            throw new \RuntimeException('OSRM did not return a routable response.');
        }

        $route = Arr::first(data_get($response, 'routes', []));
        if (!$route) {
            throw new \RuntimeException('OSRM returned no route.');
        }

        $legs = collect(data_get($route, 'legs', []))->map(function ($leg, $index) {
            return [
                'index'                 => $index,
                'distance_m'            => data_get($leg, 'distance'),
                'duration_s'            => data_get($leg, 'duration'),
                'duration_in_traffic_s' => null,
                'provider'              => $this->key(),
            ];
        })->all();

        return new TrackingProviderResult(
            provider: $this->key(),
            distanceMeters: data_get($route, 'distance'),
            durationSeconds: data_get($route, 'duration'),
            durationInTrafficSeconds: null,
            polyline: data_get($route, 'geometry'),
            coordinates: data_get($route, 'waypoints', []),
            legs: $legs,
            warnings: ['no_live_traffic'],
            confidence: 'medium',
            raw: $route
        );
    }
}
