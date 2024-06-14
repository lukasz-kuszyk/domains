<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;

final class FromGrossVatQuotas extends BaseVatQuota
{
    final public static function fromGrossVatQuotas(GrossValue $gross, VatRateValue $rate): FromGrossVatQuotas
    {
        return new self(
            self::calcNetValue($gross, $rate),
            self::calcVatValue($gross, $rate),
            $gross,
            $rate,
        );
    }

    final public function withNet(NetValue $net): FromGrossVatQuotas
    {
        $gross = GrossValue::fromNet($net, VatValue::fromNet($net, $this->getRate()));

        return FromGrossVatQuotas::fromGrossVatQuotas($gross, $this->getRate());
    }

    final public function withGross(GrossValue $gross): FromGrossVatQuotas
    {
        return FromGrossVatQuotas::fromGrossVatQuotas($gross, $this->getRate());
    }

    final public function withRate(VatRateValue $rate): FromGrossVatQuotas
    {
        return FromGrossVatQuotas::fromGrossVatQuotas($this->getGross(), $rate);
    }

    private static function calcNetValue(GrossValue $gross, VatRateValue $rate): NetValue
    {
        return NetValue::fromGross($gross, self::calcVatValue($gross, $rate));
    }

    private static function calcVatValue(GrossValue $gross, VatRateValue $rate): VatValue
    {
        return VatValue::fromGross($gross, $rate);
    }
}
