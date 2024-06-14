<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

class GrossValue extends BaseValue
{
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
