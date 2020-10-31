<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Application\FindSuspiciousReading;

use App\Shared\Domain\Command;

final class MeterReaderFindSuspiciousReadCommand implements Command
{
    private string $path;
    private string $sourceType;

    public function __construct(string $path, string $sourceType)
    {
        $this->path = $path;
        $this->sourceType = $sourceType;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function sourceType(): string
    {
        return $this->sourceType;
    }
}