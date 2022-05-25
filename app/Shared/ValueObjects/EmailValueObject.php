<?php

namespace App\Shared\ValueObjects;

use InvalidArgumentException;

abstract class EmailValueObject
{
    protected bool $nullable = false;
    protected string $field = 'email';
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->ensureNullability($value);

        if (!$this->nullable) {
            $this->ensureIsValidEmail($value);
        }

        $this->value = $value;
    }

    public function value(): ?string
    {
        return $this->value;
    }

    private function ensureNullability(?string $value)
    {
        if ($this->nullable) {
            return;
        }

        if (is_null($value)) {
            throw new InvalidArgumentException(sprintf('The %s <%s> can\'t be null', $this->field, $value));
        }
    }

    private function ensureIsValidEmail(?string $value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('The %s <%s> is not well formatted', $this->field, $value));
        }
    }
}
