<?php

declare(strict_types=1);

namespace App\Shared\Domain\Parser\File\Exception;

use App\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class FileNotFound extends \Exception implements DomainException
{
    /**
     * UnsupportedExtensionFile constructor.
     * @param ?string $name
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(
        ?string $name,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null
    ) {
        parent::__construct(
            json_encode([
                'message' => 'File not found',
                'errors' => [
                    "The file {$name} doesn't exist"
                ]
            ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}