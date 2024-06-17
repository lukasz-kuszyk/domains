<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary;

use Nauta\Domain\Monetary\Base\Money;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\Rate\BuyRate;

class BuyMoneyExchangeOperation extends BaseMoneyExchangeOperation
{
    private function __construct(
        private readonly Money $fromMoney,
        private readonly Money $toMoney,
        private readonly BuyRate $rate,
    ) {
    }

    final public static function fromMoneyAndBuyRate(Money $money, BuyRate $rate): BuyMoneyExchangeOperation
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

    public function getExchangeRate(): BuyRate
    {
        return $this->rate;
    }
}
