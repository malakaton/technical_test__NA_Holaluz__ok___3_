<?php

declare(strict_types=1);

namespace App\Tests\Mocks\MeterReader;

use App\Electricity\MeterReader\Domain\MeterReader;
use App\Electricity\MeterReader\Domain\MeterReaderClientId;
use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Electricity\MeterReader\Domain\MeterReaderPeriod;
use App\Electricity\MeterReader\Domain\MeterReaderReading;
use App\Electricity\MeterReader\Domain\MeterReaderRepository;
use App\Tests\Electricity\MeterReader\Domain\MeterReaderMedianMother;
use App\Tests\Electricity\MeterReader\Domain\MeterReaderMother;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class MeterReaderRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository MeterReaderRepository|MockInterface
     */
    private $repository;

    protected function shouldIsSuspiciousReading(MeterReader $meterReader): void
    {
        $this->MockRepository()
            ->shouldReceive('isSuspiciousReading')
            ->with(\Mockery::on(function($argument) use ($meterReader) {
                $this->assertInstanceOf(MeterReader::class, $argument);
                $this->assertInstanceOf(MeterReaderClientId::class, $argument->clientId());
                $this->assertInstanceOf(MeterReaderPeriod::class, $argument->period());
                $this->assertInstanceOf(MeterReaderReading::class, $argument->reading());
                $this->assertInstanceOf(MeterReaderMedian::class, $argument->median());

                $this->assertEquals($argument->clientId(), $meterReader->clientId());
                $this->assertEquals($argument->period(), $meterReader->period());
                $this->assertEquals($argument->reading(), $meterReader->reading());
                $this->assertEquals($argument->median(), $meterReader->median());

                return true;
            }))
            ->once()
            ->andReturnTrue();
    }

    protected function shouldCalculateMedian(int $totalRecords, int $sumReadings): int
    {
        $median = MeterReaderMedianMother::random();

        $this->MockRepository()
            ->shouldReceive('calculateMedian')
            ->with($totalRecords, $sumReadings)
            ->once()
            ->andReturn($median);

        return $median->value();
    }

    protected function shouldLoadMeterReader(string $path, string $sourceType): array
    {
        $meterReader = MeterReaderMother::random();

        $this->MockRepository()
            ->shouldReceive('loadMeterReader')
            ->with($path, $sourceType)
            ->once()
            ->andReturn([
                [
                    MeterReaderClientId::ATTRIBUTE_NAME => $meterReader->clientId()->value(),
                    MeterReaderPeriod::ATTRIBUTE_NAME => $meterReader->period()->date(),
                    MeterReaderReading::ATTRIBUTE_NAME => $meterReader->reading()->value()
                ]
            ]);

        return [
            [
                MeterReaderClientId::ATTRIBUTE_NAME => $meterReader->clientId()->value(),
                MeterReaderPeriod::ATTRIBUTE_NAME => $meterReader->period()->date(),
                MeterReaderReading::ATTRIBUTE_NAME => $meterReader->reading()->value()
            ]
        ];
    }

    /** @return MeterReaderRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(MeterReaderRepository::class);
    }
}