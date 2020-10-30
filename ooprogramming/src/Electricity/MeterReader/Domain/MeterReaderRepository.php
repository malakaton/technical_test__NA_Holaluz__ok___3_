<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

interface MeterReaderRepository
{
    public function loadMeterReader(string $path, string $sourceType): array;
    public function calculateMedian(int $totalRecords, int $sumReadings):?MeterReaderMedian;
    public function isSuspiciousReading(MeterReader $meterReader): bool;
}