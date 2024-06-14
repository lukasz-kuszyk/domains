<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\Rate\BuyRate;
use Nauta\Domain\Monetary\Rate\ExchangeRate;
use Nauta\Domain\Monetary\Rate\SellRate;

class MoneyCurrencyExchange
{
    public const OPERATION_SCALE = 2;
    public const OPERATION_ROUNDING_MODE = RoundingMode::HALF_UP;

    private function __construct(
        public readonly Money $fromMoney,
        public readonly Money $toMoney,
        public readonly ExchangeRate $rate,
    ) {
    }

    public static function fromBuyOperation(Money $money, BuyRate $rate): MoneyCurrencyExchange
    {
        if (!$money->currency->isEqualTo($rate->fromCurrency)) {
            throw new InvalidCurrencyExchangeOperationException();
        }

        $amount = BigDecimal::of($money->amount)
            ->multipliedBy($rate->rate)
            ->toScale(self::OPERATION_SCALE, self::OPERATION_ROUNDING_MODE);

        return new MoneyCurrencyExchange(
            $money,
            new Money($rate->toCurrency, $amount->toFloat()),
            $rate,
        );
    }

    public static function fromSellOperation(Money $money, SellRate $rate): MoneyCurrencyExchange
    {
        if (!$money->currency->isEqualTo($rate->fromCurrency)) {
            throw new InvalidCurrencyExchangeOperationException();
        }

        $amount = BigDecimal::of($money->amount)
            ->multipliedBy($rate->rate)
            ->toScale(self::OPERATION_SCALE, self::OPERATION_ROUNDING_MODE);

        return new MoneyCurrencyExchange(
            $money,
            new Money($rate->toCurrency, $amount->toFloat()),
            $rate,
        );
    }
}
