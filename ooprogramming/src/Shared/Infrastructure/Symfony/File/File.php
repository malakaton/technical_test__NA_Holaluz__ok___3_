<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\File;

use App\Shared\Domain\Parser\File\File as DomainFile;

abstract class File
{
    private DomainFile $file;

    public function __construct(DomainFile $file)
    {
        $this->file = $file;
    }

    public function file(): DomainFile
    {
        return $this->file;
    }
}