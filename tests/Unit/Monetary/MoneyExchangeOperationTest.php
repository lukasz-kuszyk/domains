<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Monetary;

use Nauta\Domain\Monetary\Base\Currency;
use Nauta\Domain\Monetary\Base\Money;
use Nauta\Domain\Monetary\BuyMoneyExchangeOperation;
use Nauta\Domain\Monetary\Exception\InvalidCurrencyExchangeOperationException;
use Nauta\Domain\Monetary\Rate\BuyRate;
use Nauta\Domain\Monetary\Rate\SellRate;
use Nauta\Domain\Monetary\SellMoneyExchangeOperation;
use PHPUnit\Framework\TestCase;

class MoneyExchangeOperationTest extends TestCase
{
    public function testOperationSell(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60);

        $actual = SellMoneyExchangeOperation::fromMoneyAndSellRate(
            new Money($currencyEUR, 100),
            $rate,
        );

        self::assertTrue(
            (new Money($currencyPLN, 460.0))->isEqualTo($actual->getToMoney())
        );
    }

    public function testOperationSellWithInvert(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60)
            ->invert();

        $actual = SellMoneyExchangeOperation::fromMoneyAndSellRate(
            new Money($currencyPLN, 460.0),
            $rate,
        );

        self::assertTrue(
            (new Money($currencyEUR, 100.0))->isEqualTo($actual->getToMoney())
        );
    }

    public function testOperationBuy(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50);

        $actual = BuyMoneyExchangeOperation::fromMoneyAndBuyRate(
            new Money($currencyEUR, 100),
            $rate
        );

        self::assertTrue(
            (new Money($currencyPLN, 450.0))->isEqualTo($actual->getToMoney())
        );
    }

    public function testOperationBuyWithInvert(): void
    {
        $currencyPLN = new Currency('PLN');
        $currencyEUR = new Currency('EUR');

        $rate = BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50)
            ->invert();

        $actual = BuyMoneyExchangeOperation::fromMoneyAndBuyRate(
            new Money($currencyPLN, 450.0),
            $rate
        );

        self::assertTrue(
            (new Money($currencyEUR, 100.00))->isEqualTo($actual->getToMoney())
        );
    }

    public function testOperationSellThrowInvalidCurrencyException(): void
    {
        self::expectException(InvalidCurrencyExchangeOperationException::class);

        SellMoneyExchangeOperation::fromMoneyAndSellRate(
            new Money(new Currency('A'), 1.0),
            SellRate::asSellRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }

    public function testOperationBuyThrowInvalidCurrencyException(): void
    {
        self::expectException(InvalidCurrencyExchangeOperationException::class);

        BuyMoneyExchangeOperation::fromMoneyAndBuyRate(
            new Money(new Currency('A'), 1.0),
            BuyRate::asBuyRate(new Currency('B'), new Currency('A'), 1.0)
        );
    }
}
