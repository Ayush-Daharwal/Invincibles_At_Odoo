<?php

namespace Transitops\Ai\Models;

use Transitops\Casts\Json;
use Transitops\Models\Model;
use Transitops\Traits\HasApiModelBehavior;
use Transitops\Traits\HasUuid;

class AiTaskStep extends Model
{
    use HasUuid;
    use HasApiModelBehavior;

    protected $table = 'ai_task_steps';

    protected $fillable = [
        'ai_task_uuid',
        'company_uuid',
        'created_by_uuid',
        'type',
        'status',
        'provider',
        'model',
        'tool',
        'input',
        'output',
        'usage',
        'metadata',
        'error',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'input'        => Json::class,
        'output'       => Json::class,
        'usage'        => Json::class,
        'metadata'     => Json::class,
        'error'        => Json::class,
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
    ];
}
