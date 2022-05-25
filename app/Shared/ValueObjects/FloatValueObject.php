<?php

namespace App\Shared\ValueObjects;

abstract class FloatValueObject
{
    private ?float $value;

    public function __construct(?float $value)
    {
        $this->value = $value;
    }

    public function isBiggerThan(FloatValueObject $other): bool
    {
        return $this->value() > $other->value();
    }

    public function value(): float
    {
        return $this->value;
    }
}
