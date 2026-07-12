<?php

namespace Transitops\FleetOps\Models;

use Transitops\Casts\Json;
use Transitops\FleetOps\Casts\Point;
use Transitops\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Transitops\Models\Model;
use Transitops\Traits\HasApiModelBehavior;
use Transitops\Traits\HasUuid;
use Transitops\Traits\Searchable;
use Transitops\Traits\TracksApiCredential;

class VehicleDeviceEvent extends Model
{
    use HasUuid;
    use TracksApiCredential;
    use HasApiModelBehavior;
    use SpatialTrait;
    use Searchable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'device_events';

    /**
     * Attributes that is filterable on this model.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'vehicle_device_uuid',
        'payload',
        'meta',
        'location',
        'ident',
        'protocol',
        'provider',
        'mileage',
        'state',
        'code',
        'reason',
        'comment',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payload'  => Json::class,
        'meta'     => Json::class,
        'location' => Point::class,
    ];

    /**
     * The attributes that are spatial columns.
     *
     * @var array
     */
    protected $spatialFields = ['location'];

    /**
     * Dynamic attributes that are appended to object.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Filterable params.
     *
     * @var array
     */
    protected $filterParams = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(VehicleDevice::class, 'vehicle_device_uuid');
    }
}
