<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class SourceTypeNotFound extends \Exception implements DomainException
{
    /**
     * ContentTypeNotFound constructor.
     * @param ?string $type
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(
        ?string $type,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        Throwable $previous = null
    ) {
        parent::__construct(
            json_encode([
                'message' => 'Source-type unsupported',
                'errors' => [
                    "The source-type {$type} is not supported. Use 'file' source-type"
                ]
            ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}