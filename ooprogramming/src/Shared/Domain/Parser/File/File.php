<?php

declare(strict_types=1);

namespace App\Shared\Domain\Parser\File;

use App\Shared\Domain\Parser\File\Exception\FileNotFound;

final class File
{
    private const NUM_CHARS_TO_GET_EXTENSION = -3;
    private const _XML = 'xml';
    private const _CSV = 'csv';

    private FilePath $filePath;
    private FileExtension $fileExtension;
    private FileContent $fileContent;

    /**
     * File constructor.
     * @param FilePath $filePath
     */
    public function __construct(
        FilePath $filePath
    )
    {
        $this->filePath = $filePath;
        $this->findExtension();
    }

    public static function create(
        FilePath $filePath
    ): File
    {
        return new self($filePath);
    }

    public function path(): FilePath
    {
        return $this->filePath;
    }

    public function extension(): FileExtension
    {
        return $this->fileExtension;
    }

    /**
     * @throws FileNotFound
     */
    public function setContent(): void
    {
        try {
            $this->fileContent = new FileContent(file_get_contents($this->path()->value()));
        } catch (\Exception $e) {
            throw new FileNotFound($this->path()->value());
        }
    }

    public function content(): FileContent
    {
        return $this->fileContent;
    }

    public function isXML(): bool
    {
        return $this->extension()->value() === self::_XML;
    }

    public function isCSV(): bool
    {
        return $this->extension()->value() === self::_CSV;
    }

    protected function findExtension(): void
    {
        $this->fileExtension = new FileExtension(substr($this->path()->value(), self::NUM_CHARS_TO_GET_EXTENSION));
    }
}