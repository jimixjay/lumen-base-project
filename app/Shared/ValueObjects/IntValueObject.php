<?php

namespace App\Shared\ValueObjects;

abstract class IntValueObject
{
    private ?int $value;

    public function __construct(?int $value)
    {
        $this->value = $value;
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return $this->value() > $other->value();
    }

    public function value(): ?int
    {
        return $this->value;
    }

    public function __toString()
    {
        return (string)$this->value;
    }
}
