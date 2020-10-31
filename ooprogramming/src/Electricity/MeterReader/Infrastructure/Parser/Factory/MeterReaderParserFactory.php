<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Infrastructure\Parser\Factory;

use App\Electricity\MeterReader\Infrastructure\MeterReaderFile;
use App\Shared\Domain\Parser\ParserRepository;
use App\Shared\Domain\SourceTypeNotFound;

final class MeterReaderParserFactory
{
    private const FILE_SOURCE_TYPE = 'file';
    private const URL_SOURCE_TYPE = 'url';

    /**
     * @param string $path
     * @param string $sourceType
     * @return ParserRepository
     * @throws SourceTypeNotFound
     */
    public static function basedOn(
        string $path,
        string $sourceType
    ): ParserRepository
    {
        if ($sourceType === self::FILE_SOURCE_TYPE) {
            return new MeterReaderFile($path);
        }

        if ($sourceType === self::URL_SOURCE_TYPE) {
            // ToDo: For do in the future... soon...
        }

        throw new SourceTypeNotFound($sourceType);
    }
}