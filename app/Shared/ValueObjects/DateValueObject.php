<?php

namespace App\Shared\ValueObjects;

use DateTime;
use InvalidArgumentException;
use Jimixjay\DateHelper\Date;

abstract class DateValueObject
{
    protected bool $nullable = false;
    protected string $field = 'date';
    private ?string $value;

    public function __construct(?string $value)
    {
        if (!$this->nullable && !is_null($value)) {
            $this->ensureIsValidDate($value);
        }

        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    private function ensureIsValidDate(?string $value)
    {
        if (!DateTime::createFromFormat(Date::DATE, $value)) {
            throw new InvalidArgumentException(sprintf('The %s <%s> is not well formatted', $this->field, $value));
        }
    }

    public function __toString()
    {
        return $this->value;
    }
}
