<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Infrastructure\Parser;


use App\Shared\Domain\Parser\ParserRepository;
use App\Shared\Infrastructure\Parser\ParserFromFile;
use App\Shared\Infrastructure\Symfony\File\FromXmlExtension;
use App\Shared\Infrastructure\Symfony\Exception\SymfonyException;

final class MeterReaderFile extends ParserFromFile implements ParserRepository
{
    /**
     * @throws SymfonyException
     */
    public function __toArray(): array
    {
        if ($this->file()->isXML()) {
            return (new FromXmlExtension($this->file()))->__toArray();
        }

        if ($this->file()->isCSV()) {
            return  (new FromXmlExtension($this->file()))->__toArray();
        }
    }
}