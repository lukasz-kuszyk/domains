<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use Nauta\Domain\Tax\Base\VatRate;

class NetVatQuota extends BaseVatQuota
{
    final private function __construct(
        protected Net $net,
        protected Vat $vat,
        protected Gross $gross,
        protected VatRate $rate,
    ) {
    }

    final public static function fromNetAndRate(Net $net, VatRate $rate): NetVatQuota
    {
        $vat = Vat::fromNetAndRate($net, $rate);
        $gross = Gross::fromNetAndVat($net, $vat);

        return new self(
            $net,
            $vat,
            $gross,
            $rate,
        );
    }

    public function getNet(): Net
    {
        return $this->net;
    }

    public function getVat(): Vat
    {
        return $this->vat;
    }

    public function getGross(): Gross
    {
        return $this->gross;
    }

    public function getRate(): VatRate
    {
        return $this->rate;
    }
}
