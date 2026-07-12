<?php

namespace Transitops\Ai\Models;

use Transitops\Casts\Json;
use Transitops\Models\Company;
use Transitops\Models\Model;
use Transitops\Models\User;
use Transitops\Traits\Filterable;
use Transitops\Traits\HasApiModelBehavior;
use Transitops\Traits\HasUuid;
use Transitops\Traits\Searchable;
use Illuminate\Database\Eloquent\SoftDeletes;

class AiSession extends Model
{
    use HasUuid;
    use HasApiModelBehavior;
    use Searchable;
    use Filterable;
    use SoftDeletes;

    protected $table = 'ai_sessions';

    protected $fillable = [
        'company_uuid',
        'created_by_uuid',
        'title',
        'status',
        'metadata',
        'last_message_at',
        'ended_at',
    ];

    protected $casts = [
        'metadata'        => Json::class,
        'last_message_at' => 'datetime',
        'ended_at'        => 'datetime',
    ];

    protected $searchableColumns = ['title', 'status'];

    public function tasks()
    {
        return $this->hasMany(AiTask::class, 'ai_session_uuid', 'uuid');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_uuid', 'uuid');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_uuid', 'uuid');
    }
}
