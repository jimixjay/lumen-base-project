<?php

namespace App\Shared\ValueObjects;

use InvalidArgumentException;

abstract class BoolValueObject
{
    protected bool $nullable = false;
    protected string $field = 'bool';
    private ?string $value;

    public function __construct(?bool $value)
    {
        $this->ensureNullability($value);

        $this->value = $value;
    }

    public function value(): ?bool
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
}
