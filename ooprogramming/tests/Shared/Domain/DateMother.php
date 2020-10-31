<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class DateMother
{
    public static function random(): string
    {
        return MotherCreator::random()->date('Y-m');
    }
}