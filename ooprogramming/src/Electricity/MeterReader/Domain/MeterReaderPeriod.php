<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

use App\Shared\Domain\ValueObject\DateValueObject;

final class MeterReaderPeriod extends DateValueObject
{
    public const ATTRIBUTE_NAME = 'period';
}