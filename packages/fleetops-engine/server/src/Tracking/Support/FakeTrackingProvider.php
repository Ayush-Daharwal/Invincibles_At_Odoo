<?php

namespace Transitops\FleetOps\Tracking\Support;

use Transitops\FleetOps\Tracking\Contracts\TrackingProviderInterface;
use Transitops\FleetOps\Tracking\Providers\CalculatedTrackingProvider;
use Transitops\FleetOps\Tracking\TrackingContext;
use Transitops\FleetOps\Tracking\TrackingOptions;
use Transitops\FleetOps\Tracking\TrackingProviderCapabilities;
use Transitops\FleetOps\Tracking\TrackingProviderResult;

class FakeTrackingProvider implements TrackingProviderInterface
{
    public function __construct(protected string $providerKey = 'fake')
    {
    }

    public function key(): string
    {
        return $this->providerKey;
    }

    public function capabilities(): TrackingProviderCapabilities
    {
        return new TrackingProviderCapabilities(traffic: true, perLegEta: true);
    }

    public function canTrack(TrackingContext $context): bool
    {
        return $context->canRoute();
    }

    public function track(TrackingContext $context, TrackingOptions $options): TrackingProviderResult
    {
        $result             = (new CalculatedTrackingProvider())->track($context, $options);
        $result->provider   = $this->providerKey;
        $result->confidence = 'high';
        $result->warnings   = [];

        return $result;
    }
}
