<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Infrastructure;

use App\Shared\Domain\Parser\File\Exception\FileNotFound;
use App\Shared\Domain\Parser\File\Exception\UnsupportedExtensionFile;
use App\Shared\Domain\Parser\ParserRepository;
use App\Shared\Infrastructure\Parser\ParserFromFile;
use App\Shared\Infrastructure\Symfony\File\FromCsvExtension;
use App\Shared\Infrastructure\Symfony\File\FromXmlExtension;
use App\Shared\Infrastructure\Symfony\Exception\SymfonyException;

final class MeterReaderFile extends ParserFromFile implements ParserRepository
{
    /**
     * @return array
     * @throws SymfonyException|UnsupportedExtensionFile|FileNotFound
     */
    public function __toArray(): array
    {
        if ($this->file()->isXML()) {
            return (new FromXmlExtension($this->file()))->__toArray();
        }

        if ($this->file()->isCSV()) {
            return  (new FromCsvExtension($this->file()))->__toArray();
        }

        throw new UnsupportedExtensionFile($this->file()->extension()->value());
    }
}