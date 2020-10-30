<?php

declare(strict_types=1);

namespace App\Shared\Domain\Parser;

interface ParserRepository
{
    public function __toArray(): array;
}