<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Monetary;

use Nauta\Domain\Monetary\Currency;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\Money;
use Nauta\Domain\Monetary\MoneyCurrencyExchange;
use Nauta\Domain\Monetary\Rate\BuyRate;
use Nauta\Domain\Monetary\Rate\SellRate;
use PHPUnit\Framework\TestCase;

class MoneyCurrencyExchangeTest extends TestCase
{
    public function testOperationSell(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60);

        $actual = MoneyCurrencyExchange::fromSellOperation(
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

        $rate = SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60)
            ->invert();

        $actual = MoneyCurrencyExchange::fromSellOperation(
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

        $rate = BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50);

        $actual = MoneyCurrencyExchange::fromBuyOperation(
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

        $rate = BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50)
            ->invert();

        $actual = MoneyCurrencyExchange::fromBuyOperation(
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

        MoneyCurrencyExchange::fromSellOperation(
            new Money(new Currency('A'), 1.0),
            SellRate::asSellRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }

    public function testOperationBuyThrowInvalidCurrencyException(): void
    {
        self::expectException(InvalidCurrencyExchangeOperationException::class);

        MoneyCurrencyExchange::fromBuyOperation(
            new Money(new Currency('A'), 1.0),
            BuyRate::asBuyRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }
}
