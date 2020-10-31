<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Infrastructure\Parser;

use App\Electricity\MeterReader\Domain\MeterReaderClientId;
use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Electricity\MeterReader\Domain\MeterReaderPeriod;
use App\Electricity\MeterReader\Domain\MeterReaderReading;
use App\Electricity\MeterReader\Domain\MeterReaderRepository;
use App\Electricity\MeterReader\Infrastructure\Parser\MeterReaderParser;
use App\Shared\Domain\Parser\File\Exception\UnsupportedExtensionFile;
use App\Shared\Domain\SourceTypeNotFound;
use App\Tests\Electricity\MeterReader\Domain\MeterReaderClientIdMother;
use App\Tests\Electricity\MeterReader\Domain\MeterReaderMother;
use App\Tests\Shared\Domain\DateMother;
use App\Tests\Shared\Domain\StringMother;
use PHPUnit\Framework\TestCase;

final class MeterReaderParserTest extends TestCase
{
    private const _BAD_EXTENSION_PATH = 'public/feed/reading-2016.txt';
    private const FILE_SOURCE_TYPE = 'file';
    private const _READING_AND_MEDIAN = 4000;
    private const _SUSPICIOUS_READING = 10000000000;

    private MeterReaderRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new MeterReaderParser();
    }

    /**
     * @test
     * @throws SourceTypeNotFound
     */
    public function it_should_call_source_type_not_found_exception(): void
    {
        $this->expectException(SourceTypeNotFound::class);

        $this->repository->loadMeterReader(StringMother::random(), StringMother::random());
    }

    /**
     * @test
     * @throws SourceTypeNotFound
     */
    public function it_should_call_source_unsupported_extension_exception(): void
    {
        $this->expectException(UnsupportedExtensionFile::class);

        $this->repository->loadMeterReader(self::_BAD_EXTENSION_PATH, self::FILE_SOURCE_TYPE);
    }

    /** @test */
    public function it_should_return_not_suspicious_reading(): void
    {
        $clientReader = [
            MeterReaderClientId::ATTRIBUTE_NAME => MeterReaderClientIdMother::random()->value(),
            MeterReaderPeriod::ATTRIBUTE_NAME => DateMother::random(),
            MeterReaderReading::ATTRIBUTE_NAME => self::_READING_AND_MEDIAN,
            MeterReaderMedian::ATTRIBUTE_NAME => self::_READING_AND_MEDIAN
        ];

        self::assertFalse($this->repository->isSuspiciousReading(MeterReaderMother::fromRequest($clientReader)));
    }

    /** @test */
    public function it_should_return_suspicious_reading(): void
    {
        $clientReader = [
            MeterReaderClientId::ATTRIBUTE_NAME => MeterReaderClientIdMother::random()->value(),
            MeterReaderPeriod::ATTRIBUTE_NAME => DateMother::random(),
            MeterReaderReading::ATTRIBUTE_NAME => self::_SUSPICIOUS_READING,
            MeterReaderMedian::ATTRIBUTE_NAME => self::_READING_AND_MEDIAN
        ];

        self::assertTrue($this->repository->isSuspiciousReading(MeterReaderMother::fromRequest($clientReader)));
    }
}