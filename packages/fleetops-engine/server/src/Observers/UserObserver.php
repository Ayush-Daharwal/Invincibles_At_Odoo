<?php

namespace Transitops\FleetOps\Observers;

use Transitops\FleetOps\Models\Driver;
use Transitops\Models\User;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @return void
     */
    public function deleted(User $user)
    {
        // if the user deleted is a driver, delete their driver record to
        Driver::where('user_uuid', $user->uuid)->delete();
    }
}
