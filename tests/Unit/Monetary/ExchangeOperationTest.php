<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Monetary;

use Nauta\Domain\Monetary\Currency;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\ExchangeOperation;
use Nauta\Domain\Monetary\ExchangeRate;
use Nauta\Domain\Monetary\Money;
use PHPUnit\Framework\TestCase;

class ExchangeOperationTest extends TestCase
{
    public function testOperationSell(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = ExchangeRate::asSellRate($currencyEUR, $currencyPLN, 4.60);

        $actual = ExchangeOperation::fromSellOperation(
            new Money($currencyEUR, 100),
            $rate,
        );

        self::assertTrue(
            (new Money($currencyPLN, 460.0))->isEqualTo($actual->toMoney)
        );
    }

    public function testOperationSellWithInvert(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = ExchangeRate::asSellRate($currencyEUR, $currencyPLN, 4.60)
            ->invert();

        $actual = ExchangeOperation::fromSellOperation(
            new Money($currencyPLN, 460.0),
            $rate,
        );

        self::assertTrue(
            (new Money($currencyEUR, 100.0))->isEqualTo($actual->toMoney)
        );
    }

    public function testOperationBuy(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = ExchangeRate::asBuyRate($currencyEUR, $currencyPLN, 4.50);

        $actual = ExchangeOperation::fromBuyOperation(
            new Money($currencyEUR, 100),
            $rate
        );

        self::assertTrue(
            (new Money($currencyPLN, 450.0))->isEqualTo($actual->toMoney)
        );
    }

    public function testOperationBuyWithInvert(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = ExchangeRate::asBuyRate($currencyEUR, $currencyPLN, 4.50)
            ->invert();

        $actual = ExchangeOperation::fromBuyOperation(
            new Money($currencyPLN, 450.0),
            $rate
        );

        self::assertTrue(
            (new Money($currencyEUR, 100.00))->isEqualTo($actual->toMoney)
        );
    }

    public function testOperationSellThrowInvalidCurrencyException(): void
    {
        self::expectException(InvalidCurrencyExchangeOperationException::class);

        ExchangeOperation::fromSellOperation(
            new Money(new Currency('A'), 1.0),
            ExchangeRate::asSellRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }

    public function testOperationBuyThrowInvalidCurrencyException(): void
    {
        self::expectException(InvalidCurrencyExchangeOperationException::class);

        ExchangeOperation::fromBuyOperation(
            new Money(new Currency('A'), 1.0),
            ExchangeRate::asBuyRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }
}
