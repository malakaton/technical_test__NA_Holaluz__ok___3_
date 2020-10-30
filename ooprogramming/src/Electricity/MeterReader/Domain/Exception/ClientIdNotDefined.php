<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Domain;

use App\Shared\Domain\DomainException;
use Throwable;

final class ClientIdNotDefined extends \Exception implements DomainException
{
    /**
     * ClientIdNotDefined constructor.
     * @param int $code
     * @param Throwable|null $previous
     * @throws \JsonException
     */
    public function __construct(int $code = 404, Throwable $previous = null) {
        parent::__construct(
            json_encode([
                'message' => 'The attribute clientID has not been found',
                'errors' => [
                    'clientID' => [
                        "Attribute not found. Check headers of file"
                    ]
                ]
            ], JSON_THROW_ON_ERROR),
            $code,
            $previous
        );
    }
}