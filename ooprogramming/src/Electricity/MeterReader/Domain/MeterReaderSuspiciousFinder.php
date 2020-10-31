<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\Exception\ClientIdNotDefined;

final class MeterReaderSuspiciousFinder
{
    private MeterReaderRepository $repository;

    public function __construct(
        MeterReaderRepository $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @param string $path
     * @param string $sourceType
     * @return array|null
     * @throws ClientIDNotDefined
     */
    public function __invoke(string $path, string $sourceType): ?array
    {
        $result = [];

        $meterReaders = $this->repository->loadMeterReader($path, $sourceType);

        $meterReaders = $this->groupByClient($meterReaders);

        foreach ($meterReaders as $readsByClient) {
            foreach ($readsByClient as $read){
                if (is_array($read)) {
                    $meterReader = MeterReader::create(
                        new MeterReaderClientId($read[MeterReaderClientId::ATTRIBUTE_NAME]),
                        new MeterReaderPeriod($read[MeterReaderPeriod::ATTRIBUTE_NAME] ?? null),
                        new MeterReaderReading((int) ($read[MeterReaderReading::ATTRIBUTE_NAME] ?? 0)),
                        $readsByClient[MeterReaderMedian::ATTRIBUTE_NAME] ?? 0
                    );
                    $this->repository->isSuspiciousReading($meterReader) ? $result[] = $meterReader : null;
                }
            }
        }

        return $result;
    }

    /**
     * @param array $meterReaders
     * @return array
     * @throws ClientIDNotDefined
     */
    private function groupByClient(array $meterReaders): array
    {
        $result = [];
        $totalRows = count($meterReaders) - 1;
        $sumReadings = 0;

        foreach ($meterReaders as $key => $read) {
            $this->guard($read);

            $sumReadings += $read[MeterReaderReading::ATTRIBUTE_NAME];

            $result[$read[MeterReaderClientId::ATTRIBUTE_NAME]][] = $read;

            if (($key === $totalRows) ||
                (isset($meterReaders[$key + 1]) && $read[MeterReaderClientId::ATTRIBUTE_NAME] !==
                    $meterReaders[$key + 1][MeterReaderClientId::ATTRIBUTE_NAME])) {
                $result[$read[MeterReaderClientId::ATTRIBUTE_NAME]][MeterReaderMedian::ATTRIBUTE_NAME] =
                    $this->repository->calculateMedian(
                        count($result[$read[MeterReaderClientId::ATTRIBUTE_NAME]]),
                        $sumReadings
                    );

                $sumReadings = 0;
            }
        }

        return $result;
    }

    /**
     * @param array $read
     * @throws ClientIDNotDefined
     */
    private function guard(array $read): void
    {
        if (!isset($read[MeterReaderClientId::ATTRIBUTE_NAME])) {
            throw new ClientIDNotDefined();
        }
    }
}