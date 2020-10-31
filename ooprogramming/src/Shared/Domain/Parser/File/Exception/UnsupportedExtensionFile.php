<?php

declare(strict_types=1);

namespace App\Shared\Domain\Parser\File\Exception;

use App\Shared\Domain\DomainException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UnsupportedExtensionFile extends \Exception implements DomainException
{
    /**
     * UnsupportedExtensionFile constructor.
     * @param ?string $extension
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(
        ?string $extension,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null
    ) {
        parent::__construct(
            json_encode([
                'message' => 'File extension unsupported',
                'errors' => [
                    "The extension file {$extension} is not supported. Use 'xml' or 'csv' extension file"
                ]
            ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}