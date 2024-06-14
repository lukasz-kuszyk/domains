<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;

class ExchangeOperation
{
    public const OPERATION_SCALE = 2;
    public const OPERATION_ROUNDING_MODE = RoundingMode::HALF_UP;

    private function __construct(
        public readonly Money $fromMoney,
        public readonly Money $toMoney,
        public readonly ExchangeRate $rate,
    ) {
    }

    public static function fromBuyOperation(Money $money, BuyRate $rate): ExchangeOperation
    {
        if (!$money->currency->isEqualTo($rate->fromCurrency)) {
            throw new InvalidCurrencyExchangeOperationException();
        }

        $amount = BigDecimal::of($money->amount)
            ->multipliedBy($rate->rate)
            ->toScale(self::OPERATION_SCALE, self::OPERATION_ROUNDING_MODE);

        return new ExchangeOperation(
            $money,
            new Money($rate->toCurrency, $amount->toFloat()),
            $rate,
        );
    }

    public static function fromSellOperation(Money $money, SellRate $rate): ExchangeOperation
    {
        if (!$money->currency->isEqualTo($rate->fromCurrency)) {
            throw new InvalidCurrencyExchangeOperationException();
        }

        $amount = BigDecimal::of($money->amount)
            ->multipliedBy($rate->rate)
            ->toScale(self::OPERATION_SCALE, self::OPERATION_ROUNDING_MODE);

        return new ExchangeOperation(
            $money,
            new Money($rate->toCurrency, $amount->toFloat()),
            $rate,
        );
    }
}
