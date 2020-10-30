<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

abstract class DateValueObject
{
    protected const _toFormatDate = 'Y-m';

    protected string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function toFormatDate(): string
    {
        $dateTime = new \DateTime($this->date);

        return $dateTime->format(self::_toFormatDate);
    }
}