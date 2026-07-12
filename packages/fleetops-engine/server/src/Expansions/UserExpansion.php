<?php

namespace Transitops\FleetOps\Expansions;

use Transitops\Build\Expansion;
use Transitops\FleetOps\Models\Contact;
use Transitops\FleetOps\Models\Driver;

class UserExpansion implements Expansion
{
    /**
     * Get the target class to expand.
     *
     * @return string|Class
     */
    public static function target()
    {
        return \Transitops\Models\User::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function driver()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->hasOne(Driver::class)->without('user');
        };
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function currentDriverSession()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->driver()->where('company_uuid', session('company'));
        };
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public static function driverProfiles()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->hasMany(Driver::class);
        };
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function customer()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->hasOne(Contact::class, 'user_uuid', 'uuid')->where('type', 'customer')->without('user');
        };
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public static function contact()
    {
        return function () {
            /** @var \Illuminate\Database\Eloquent\Model $this */
            return $this->hasOne(Contact::class, 'user_uuid', 'uuid')->without('user');
        };
    }
}
