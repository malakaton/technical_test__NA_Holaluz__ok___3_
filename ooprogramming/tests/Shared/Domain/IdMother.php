<?php

declare(strict_types=1);

namespace App\Tests\Shared\Domain;

final class IdMother
{
    public static function random(): string
    {
        return MotherCreator::random()->regexify('[A-Za-z0-9]{20}');
    }
}