<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary;

use Nauta\Domain\Monetary\Base\Money;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\Rate\SellRate;

class SellMoneyExchangeOperation extends BaseMoneyExchangeOperation
{
    private function __construct(
        private readonly Money $fromMoney,
        private readonly Money $toMoney,
        private readonly SellRate $rate,
    ) {
    }

    final public static function fromMoneyAndSellRate(Money $money, SellRate $rate): SellMoneyExchangeOperation
    {
        if (!$money->getCurrency()->isEqualTo($rate->fromCurrency)) {
            throw new InvalidCurrencyExchangeOperationException();
        }

        return new self(
            $money,
            new Money($rate->toCurrency, self::calculateExchangeAmount($money, $rate)->toFloat()),
            $rate,
        );
    }

    public function getFromMoney(): Money
    {
        return $this->fromMoney;
    }

    public function getToMoney(): Money
    {
        return $this->toMoney;
    }

    public function getExchangeRate(): SellRate
    {
        return $this->rate;
    }
}
