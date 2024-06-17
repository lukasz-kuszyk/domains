<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use Nauta\Domain\Tax\Base\VatRate;

abstract class BaseVatQuota
{
    abstract public function getNet(): Net;

    abstract public function getVat(): Vat;

    abstract public function getGross(): Gross;

    abstract public function getRate(): VatRate;
}
