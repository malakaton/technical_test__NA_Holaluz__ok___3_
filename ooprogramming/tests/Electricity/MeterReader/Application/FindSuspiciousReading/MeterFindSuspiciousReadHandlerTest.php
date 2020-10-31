<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Application\FindSuspiciousReading;

use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterFindSuspiciousReadHandler;
use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterReaderSuspiciousFinder;
use App\Tests\Electricity\MeterReader\Domain\MeterReaderMother;
use App\Tests\Mocks\MeterReader\MeterReaderRepositoryMockUnitTestCase;

final class MeterFindSuspiciousReadHandlerTest extends MeterReaderRepositoryMockUnitTestCase
{
    private MeterFindSuspiciousReadHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = new MeterFindSuspiciousReadHandler(new MeterReaderSuspiciousFinder($this->MockRepository()));
    }

    /**
     * @test
     */
    public function it_should_load_meter_readers(): void
    {
        $command = MeterFindSuspiciousReadCommandMother::random();

        $meterReaders = MeterReaderMother::random();

        $this->shouldLoadMeterReader($meterReaders);

        $this->dispatch($command, $this->handler);
    }
}