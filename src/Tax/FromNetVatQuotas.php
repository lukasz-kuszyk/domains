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

    final public function withNet(NetValue $net): FromNetVatQuotas
    {
        return FromNetVatQuotas::fromNetVatQuotas($net, $this->getRate());
    }

    final public function withGross(GrossValue $gross): FromNetVatQuotas
    {
        $net = NetValue::fromGross($gross, VatValue::fromGross($gross, $this->getRate()));

        return FromNetVatQuotas::fromNetVatQuotas($net, $this->getRate());
    }

    final public function withRate(VatRateValue $rate): FromNetVatQuotas
    {
        return FromNetVatQuotas::fromNetVatQuotas($this->getNet(), $rate);
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
