<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;

class NetValue extends BaseValue
{
    public static function fromBigDecimal(BigDecimal $value): NetValue
    {
        return new self($value);
    }

    final public static function fromNumeric(float|int $value): NetValue
    {
        return new self(BigDecimal::of($value));
    }

    final public static function fromGross(GrossValue $gross, VatValue $vat): NetValue
    {
        return self::fromBigDecimal($gross->subtract($vat)->toBigDecimal());
    }

    final public function add(VatValue $vat): GrossValue
    {
        return GrossValue::fromBigDecimal($this->toBigDecimal()->plus($vat->toBigDecimal()));
    }
}
