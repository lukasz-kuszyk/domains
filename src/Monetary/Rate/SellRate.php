<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary\Rate;

use Brick\Math\BigDecimal;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;

class SellRate extends ExchangeRate implements IsSelfComparable
{
    public function isEqualTo(SellRate $rate): bool
    {
        return BigDecimal::of($rate->getRateAsFraction())->isEqualTo($this->getRateAsFraction());
    }
}
