<?php

namespace App\Shared\ValueObjects;

use InvalidArgumentException;

abstract class StringValueObject
{
    protected bool $nullable = false;
    protected string $field = 'string';
    protected int $maxLength;
    protected int $minLength;
    private ?string $value;

    public function __construct(?string $value)
    {
        $this->ensureNullability($value);

        if (!$this->nullable && !is_null($value)) {
            $this->ensureNotTooLong($value);
            $this->ensureNotTooSort($value);
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

    private function ensureNotTooLong(string $value)
    {
        if ($this->maxLength != -1 && strlen($value) > $this->maxLength) {
            throw new InvalidArgumentException(
                sprintf('The %s is too long <%s> (%s max)',
                        $this->field,
                        $value,
                        $this->maxLength
                )
            );
        }
    }

    private function ensureNotTooSort(string $value)
    {
        if (strlen($value) < $this->minLength) {
            throw new InvalidArgumentException(
                sprintf('The %s is too sort <%s> (%s min)',
                        $this->field,
                        $value,
                        $this->minLength
                )
            );
        }
    }

    public function __toString()
    {
        return $this->value;
    }
}
