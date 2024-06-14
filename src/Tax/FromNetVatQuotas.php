<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;

final class FromNetVatQuotas extends BaseVatQuota
{
    final public static function fromNetVatQuotas(NetValue $net, VatRateValue $rate): FromNetVatQuotas
    {
        return new self(
            $net,
            self::getVatValue($net, $rate),
            self::getGrossValue($net, $rate),
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

    private static function getVatValue(NetValue $net, VatRateValue $rate): VatValue
    {
        return VatValue::fromNet($net, $rate);
    }

    private static function getGrossValue(NetValue $net, VatRateValue $rate): GrossValue
    {
        return GrossValue::fromNet($net, self::getVatValue($net, $rate));
    }
}
