<?php

namespace Transitops\FleetOps\Support;

use Transitops\FleetOps\Models\Contact;
use Transitops\FleetOps\Models\Place;
use Transitops\Support\ParsePhone as ParsePhoneUtil;
use libphonenumber\PhoneNumberFormat;

class ParsePhone extends ParsePhoneUtil
{
    public static function fromContact(Contact $contact, $options = [], $format = PhoneNumberFormat::E164)
    {
        return static::fromModel($contact, $options, $format);
    }

    public static function fromPlace(Place $place, $options = [], $format = PhoneNumberFormat::E164)
    {
        return static::fromModel($place, $options, $format);
    }
}
