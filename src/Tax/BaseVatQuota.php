<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax;

use Nauta\Domain\Contracts\Logic\IsSelfComparable;
use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use Nauta\Domain\Tax\Base\VatRate;

abstract class BaseVatQuota implements IsSelfComparable
{
    abstract public function getNet(): Net;

    abstract public function getVat(): Vat;

    abstract public function getGross(): Gross;

    abstract public function getRate(): VatRate;

    public function isEqualTo(BaseVatQuota $quota): bool
    {
        return $quota->getNet()->isEqualTo($this->getNet())
            && $quota->getVat()->isEqualTo($this->getVat())
            && $quota->getGross()->isEqualTo($this->getGross())
            && $quota->getRate()->isEqualTo($this->getRate());
    }
}
