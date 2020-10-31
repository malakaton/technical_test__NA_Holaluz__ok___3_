<?php

declare(strict_types=1);

namespace App\Tests\Mocks\MeterReader;

use App\Electricity\MeterReader\Domain\MeterReader;
use App\Electricity\MeterReader\Domain\MeterReaderRepository;
use App\Tests\Shared\Infrastructure\PhpUnit\UnitTestCase;
use Mockery\MockInterface;

abstract class MeterReaderRepositoryMockUnitTestCase extends UnitTestCase
{
    /**
     * @var $repository MeterReaderRepository|MockInterface
     */
    private $repository;

    protected function shouldLoadMeterReader(array $meterReaders): void
    {
        $this->MockRepository()
            ->shouldReceive('loadMeterReader')
            ->with(\Mockery::on(function($argument) use ($book) {
                $this->assertInstanceOf(Book::class, $argument);
                $this->assertInstanceOf(BookUuid::class, $argument->uuid());
                $this->assertInstanceOf(AuthorUuid::class, $argument->authorUuid());
                $this->assertInstanceOf(BookTitle::class, $argument->title());
                $this->assertInstanceOf(BookDescription::class, $argument->description());
                $this->assertInstanceOf(BookContent::class, $argument->content());

                $this->assertEquals($argument->authorUuid(), $book->authorUuid());
                $this->assertEquals($argument->title(), $book->title());
                $this->assertEquals($argument->description(), $book->description());
                $this->assertEquals($argument->content(), $book->content());

                return true;
            }))
            ->once()
            ->andReturnNull();
    }

    protected function shouldCalculateMedian(int $totalRecords, int $sumReadings): void
    {
        $this->MockRepository()
            ->shouldReceive('calculateMedian')
            ->with(\Mockery::on(function($argument) use ($uuid) {
                $this->assertInstanceOf(BookUuid::class, $argument);
                $this->assertSame($this->randomBookUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $uuid->value());

                return true;
            }))
            ->once()
            ->andReturn($book);
    }

    protected function shouldIsSuspiciousReading(MeterReader $meterReader): void
    {
        $this->MockRepository()
            ->shouldReceive('isSuspiciousReading')
            ->with(\Mockery::on(function($argument) use ($uuid) {
                $this->assertInstanceOf(BookUuid::class, $argument);
                $this->assertSame($this->randomBookUuid->value(), $argument->value());
                $this->assertEquals($argument->value(), $uuid->value());

                return true;
            }))
            ->once()
            ->andReturn($book);
    }

    /** @return MeterReaderRepository|MockInterface */
    protected function MockRepository(): MockInterface
    {
        return $this->repository = $this->repository ?: $this->mock(MeterReaderRepository::class);
    }
}