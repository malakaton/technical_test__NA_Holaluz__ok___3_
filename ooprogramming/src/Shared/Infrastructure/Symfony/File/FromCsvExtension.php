<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\File;

use BooksManagement\Shared\Domain\Request\RequestRepository;
use BooksManagement\Shared\Infrastructure\Symfony\Exception\SymfonyException;

final class FromCsvExtension extends File
{
    /**
     * @return array
     * @throws SymfonyException
     */
    public function __toArray(): array
    {
        try {
            $csv = [];

            $json = json_encode($csv);
            return json_decode($json, true);
        } catch (\Exception $e) {
            throw new SymfonyException($e->getMessage(), $e->getTrace());
        }
    }
}