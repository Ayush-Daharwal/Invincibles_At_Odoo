<?php

namespace Transitops\Ai\Contracts;

use Transitops\Ai\Models\AiTask;

interface AIContextCapabilityInterface extends AICapabilityInterface
{
    public function shouldResolve(AiTask $task): bool;

    public function resolve(AiTask $task): array;
}
