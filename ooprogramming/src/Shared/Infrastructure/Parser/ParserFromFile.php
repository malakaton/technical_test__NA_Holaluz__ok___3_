<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Parser;

use App\Shared\Domain\Parser\File\File;
use App\Shared\Domain\Parser\File\FilePath;

abstract class ParserFromFile
{
    private File $file;

    public function __construct(string $path)
    {
        $this->file = File::create(new FilePath($path));
    }

    public function file(): File
    {
        return $this->file;
    }
}