<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary\Base;

use Brick\Math\BigDecimal;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;
use Nauta\Domain\Contracts\Monetary\IsMoney;

class Money implements IsMoney, IsSelfComparable
{
    public function __construct(
        private readonly Currency $currency,
        private readonly float $amount,
    ) {
    }

    public function isEqualTo(Money $money): bool
    {
        return $money->getCurrency()->isEqualTo($this->getCurrency())
            && BigDecimal::of($money->getAmountAsNumber())->isEqualTo($this->getAmountAsNumber());
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmountAsNumber(): float|int
    {
        return $this->amount;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency->getCurrencyCode();
    }
}
