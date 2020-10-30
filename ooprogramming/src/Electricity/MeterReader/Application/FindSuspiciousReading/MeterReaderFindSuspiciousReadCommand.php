<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Application\FindSuspiciousReading;

final class MeterReaderFindSuspiciousReadCommand
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