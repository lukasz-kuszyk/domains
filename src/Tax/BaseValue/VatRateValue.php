<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;

class VatRateValue extends BaseValue
{
    public function getPercent(): BigDecimal
    {
        return $this->toBigDecimal();
    }
}
