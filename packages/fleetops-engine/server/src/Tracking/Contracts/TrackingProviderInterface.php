<?php

namespace Transitops\FleetOps\Tracking\Contracts;

use Transitops\FleetOps\Tracking\TrackingContext;
use Transitops\FleetOps\Tracking\TrackingOptions;
use Transitops\FleetOps\Tracking\TrackingProviderCapabilities;
use Transitops\FleetOps\Tracking\TrackingProviderResult;

interface TrackingProviderInterface
{
    public function key(): string;

    public function capabilities(): TrackingProviderCapabilities;

    public function canTrack(TrackingContext $context): bool;

    public function track(TrackingContext $context, TrackingOptions $options): TrackingProviderResult;
}
