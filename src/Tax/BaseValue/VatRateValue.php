<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;

/**
 * @throws \InvalidArgumentException
 */
class VatRateValue extends BaseValue
{
    public static function fromBigDecimal(BigDecimal $value): VatRateValue
    {
        if ($value->hasNonZeroFractionalPart()) {
            throw new \InvalidArgumentException('VAT Rate must not be fraction.');
        }

        return new self($value);
    }

    final public static function fromNumeric(float|int $value): VatRateValue
    {
        return new self(BigDecimal::of($value));
    }

    public function getPercent(): BigDecimal
    {
        return $this->toBigDecimal();
    }
}
