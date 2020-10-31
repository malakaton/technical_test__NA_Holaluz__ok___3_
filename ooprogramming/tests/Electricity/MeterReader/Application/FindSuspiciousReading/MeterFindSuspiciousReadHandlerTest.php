<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Application\FindSuspiciousReading;

use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterFindSuspiciousReadHandler;
use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterReaderSuspiciousFinder;
use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Electricity\MeterReader\Domain\MeterReaderReading;
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
    public function it_should_find_suspicious_reading(): void
    {
        $command = MeterFindSuspiciousReadCommandMother::random();

        $arrayMeterReaders = $this->shouldLoadMeterReader($command->path(), $command->sourceType());

        $arrayMeterReaders[0][MeterReaderMedian::ATTRIBUTE_NAME] = $this->shouldCalculateMedian(
            count($arrayMeterReaders),
            $arrayMeterReaders[0][MeterReaderReading::ATTRIBUTE_NAME]
        );

        $this->shouldIsSuspiciousReading(MeterReaderMother::fromRequest($arrayMeterReaders[0]));

        $this->dispatch($command, $this->handler);
    }
}