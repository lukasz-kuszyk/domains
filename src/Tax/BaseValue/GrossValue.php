<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;

class GrossValue extends BaseValue
{
    final public static function fromBigDecimal(BigDecimal $value): GrossValue
    {
        return new self($value);
    }

    final public static function fromNumeric(float|int $value): GrossValue
    {
        return new self(BigDecimal::of($value));
    }

    final public static function fromNet(NetValue $net, VatValue $vat): GrossValue
    {
        return self::fromBigDecimal($net->add($vat)->toBigDecimal());
    }

    final public function subtract(VatValue $vat): NetValue
    {
        $result = $this->toBigDecimal()->minus($vat->toBigDecimal());

        return NetValue::fromBigDecimal($result);
    }
}
