<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

class NetValue extends BaseValue
{
    final public static function fromGross(GrossValue $gross, VatValue $vat): NetValue
    {
        return self::fromBigDecimal($gross->subtract($vat)->toBigDecimal());
    }

    final public function add(VatValue $vat): GrossValue
    {
        return GrossValue::fromBigDecimal($this->toBigDecimal()->plus($vat->toBigDecimal()));
    }
}
