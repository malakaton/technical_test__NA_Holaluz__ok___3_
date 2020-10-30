<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

use App\Shared\Domain\ValueObject\IntValueObject;

final class MeterReaderMedian extends IntValueObject
{
    public const ATTRIBUTE_NAME = 'median';
}