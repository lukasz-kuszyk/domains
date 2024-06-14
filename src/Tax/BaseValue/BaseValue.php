<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;

abstract class BaseValue implements \Stringable
{
    final public function toBigDecimal(): BigDecimal
    {
        return $this->value;
    }

    public static function fromBigDecimal(BigDecimal $value): static
    {
        return new static($value);
    }

    public static function fromNumeric(float|int $value): static
    {
        return new static(BigDecimal::of($value));
    }

    public function isEqualTo(BaseValue $value): bool
    {
        return $value instanceof static && $value->toBigDecimal()->isEqualTo($this->value);
    }

    final public function __toString(): string
    {
        return (string) $this->value->toFloat();
    }

    final private function __construct(
        private readonly BigDecimal $value,
    ) {
    }
}
