<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;
use Stringable;

abstract class BaseValue implements Stringable
{
    abstract public static function fromBigDecimal(BigDecimal $value): BaseValue;

    abstract public static function fromNumeric(float|int $value): BaseValue;

    final public function toBigDecimal(): BigDecimal
    {
        return $this->value;
    }

    final public function __toString(): string
    {
        return (string) $this->value->toFloat();
    }

    protected function __construct(
        private readonly BigDecimal $value,
    ) {
    }
}
