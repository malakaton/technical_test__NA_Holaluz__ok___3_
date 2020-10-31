<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\File;

use App\Shared\Infrastructure\Symfony\Exception\SymfonyException;

final class FromCsvExtension extends File
{
    /**
     * @return array
     * @throws SymfonyException
     */
    public function __toArray(): array
    {
        try {
            $csv = array_map("str_getcsv", file($this->file()->path()->value(),FILE_SKIP_EMPTY_LINES));
            $keys = array_shift($csv);

            foreach ($csv as $i=>$row) {
                $csv[$i] = array_combine($keys, $row);
            }

            return $csv;
        } catch (\Exception $e) {
            throw new SymfonyException($e->getMessage(), $e->getTrace());
        }
    }
}