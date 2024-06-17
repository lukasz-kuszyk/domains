<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Nauta\Domain\Monetary\Base\Money;
use Nauta\Domain\Monetary\Rate\ExchangeRate;

abstract class BaseMoneyExchangeOperation
{
    public const OPERATION_SCALE = 2;
    public const OPERATION_ROUNDING_MODE = RoundingMode::HALF_UP;

    abstract public function getFromMoney(): Money;

    abstract public function getToMoney(): Money;

    abstract public function getExchangeRate(): ExchangeRate;

    protected static function calculateExchangeAmount(Money $money, ExchangeRate $rate): BigDecimal
    {
        return BigDecimal::of($money->getAmountAsNumber())
            ->multipliedBy($rate->getRateAsFraction())
            ->toScale(self::OPERATION_SCALE, self::OPERATION_ROUNDING_MODE);
    }
}
