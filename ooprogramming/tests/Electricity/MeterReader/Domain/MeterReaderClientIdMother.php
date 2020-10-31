<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\MeterReaderClientId;
use App\Tests\Shared\Domain\IdMother;

final class MeterReaderClientIdMother
{
    public static function create(string $value): MeterReaderClientId
    {
        return new MeterReaderClientId($value);
    }

    public static function random(): MeterReaderClientId
    {
        return self::create(IdMother::random());
    }
}