<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;

abstract class BaseVatQuota
{
    abstract public function withNet(NetValue $net): BaseVatQuota;

    abstract public function withGross(GrossValue $gross): BaseVatQuota;

    abstract public function withRate(VatRateValue $rate): BaseVatQuota;

    final protected function __construct(
        private readonly NetValue $net,
        private readonly VatValue $vat,
        private readonly GrossValue $gross,
        private readonly VatRateValue $rate,
    ) {
    }

    public static function fromNet(NetValue $net, VatRateValue $rate): FromNetVatQuotas
    {
        return FromNetVatQuotas::fromNetVatQuotas($net, $rate);
    }

    public static function fromGross(GrossValue $gross, VatRateValue $rate): FromGrossVatQuotas
    {
        return FromGrossVatQuotas::fromGrossVatQuotas($gross, $rate);
    }

    public function isEqualTo(BaseVatQuota $quota): bool
    {
        return $quota->net->isEqualTo($this->net)
            && $quota->gross->isEqualTo($this->gross)
            && $quota->vat->isEqualTo($this->vat)
            && $quota->rate->isEqualTo($this->rate);
    }

    final public function getNet(): NetValue
    {
        return $this->net;
    }

    final public function getVat(): VatValue
    {
        return $this->vat;
    }

    final public function getGross(): GrossValue
    {
        return $this->gross;
    }

    final public function getRate(): VatRateValue
    {
        return $this->rate;
    }
}
