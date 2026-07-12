<?php

namespace Transitops\FleetOps\Exceptions;

use Transitops\Models\User;

class CustomerUserConflictException extends UserAlreadyExistsException
{
    public function __construct(string $message = '', ?User $user = null, int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $user, $code, $previous);
    }
}
