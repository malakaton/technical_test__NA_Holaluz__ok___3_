<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

final class MeterReader
{
    private MeterReaderClientId $clientId;
    private MeterReaderPeriod $period;
    private MeterReaderReading $reading;
    private MeterReaderMedian $median;

    public function __construct(
        MeterReaderClientId $clientId,
        MeterReaderPeriod $period,
        MeterReaderReading $reading,
        MeterReaderMedian $median
    )
    {
        $this->clientId = $clientId;
        $this->period = $period;
        $this->reading = $reading;
        $this->median = $median;
    }

    public static function create(
        MeterReaderClientId $clientId,
        MeterReaderPeriod $period,
        MeterReaderReading $reading,
        MeterReaderMedian $median
    ): MeterReader
    {
        return new self($clientId, $period, $reading, $median);
    }

    public function clientId(): MeterReaderClientId
    {
        return $this->clientId;
    }

    public function period(): MeterReaderPeriod
    {
        return $this->period;
    }

    public function reading(): MeterReaderReading
    {
        return $this->reading;
    }

    public function median(): MeterReaderMedian
    {
        return $this->median;
    }
}