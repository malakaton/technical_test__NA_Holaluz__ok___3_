<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

final class MeterReaderClientId extends StringValueObject
{
    public const ATTRIBUTE_NAME = 'clientID';
}