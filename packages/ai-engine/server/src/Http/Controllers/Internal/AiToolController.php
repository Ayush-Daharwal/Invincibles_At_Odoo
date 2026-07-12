<?php

namespace Transitops\Ai\Http\Controllers\Internal;

use Transitops\Ai\Support\AiCapabilityRegistry;
use Transitops\Http\Controllers\Controller;

class AiToolController extends Controller
{
    public function index(AiCapabilityRegistry $registry)
    {
        return response()->json([
            'tools' => $registry->list(),
        ]);
    }
}
