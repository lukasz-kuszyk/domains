# Domains
- [Tax](#tax)
- [Monetary](#monetary)

## Tax
Calculating net, gross, and VAT values.

```php
// Example usage 1

$quota = BaseVatQuota::fromNet(
    NetValue::fromNumeric(100),
    VatRateValue::fromNumeric(.23)
);

echo sprintf(
    'Net: %.2f | Rate: %.2f | Calculated Gross: %.2f',
    $quota->getNet()->__toString(),
    $quota->getRate()->__toString(),
    $quota->getGross()->__toString(),
) . PHP_EOL;

// -- Result --
// Net: 100.00 | Rate: 0.23 | Calculated Gross: 123.00

// Example usage 2

$quota = FromGrossVatQuotas::fromGrossVatQuotas(
    GrossValue::fromNumeric(123),
    VatRateValue::fromNumeric(.23)
);

echo sprintf(
    'Gross: %.2f | Rate: %.2f | Calculated Net: %.2f',
    $quota->getGross()->__toString(),
    $quota->getRate()->__toString(),
    $quota->getNet()->__toString(),
) . PHP_EOL;

// -- Result --
// Gross: 123.00 | Rate: 0.23 | Calculated Net: 100.00

// Example usage 3

$net = NetValue::fromNumeric(100);
$vat = VatValue::fromNumeric(23);

$gross = $net->add($vat);

echo sprintf(
    'Net: %.2f | Vat: %.2f | Calculated Gross: %.2f',
    $net->__toString(),
    $vat->__toString(),
    $gross->__toString(),
) . PHP_EOL;

// -- Result --
// Net: 100.00 | Vat: 23.00 | Calculated Gross: 123.00

// Example usage 4

$gross = GrossValue::fromNumeric(123);
$vat = VatValue::fromNumeric(23);

$net = $gross->subtract($vat);

echo sprintf(
        'Gross: %.2f | Vat: %.2f | Calculated Net: %.2f',
        $gross->__toString(),
        $vat->__toString(),
        $net->__toString(),
    ) . PHP_EOL;

// -- Result --
// Gross: 123.00 | Vat: 23.00 | Calculated Net: 100.00
```

inspired by: https://www.streamsoft.pl/blog-it/oop-in-action/

## Monetary
Managing amounts in different currencies.

**Note:** "Buy" and "Sell" operations & rates are from a financial institution, currency exchange provider, or a bank. If the customer sells currency, it is recommended to use a buy operation (the customer is the other side of the operation).

```php
$currencyEUR = new Currency('EUR');
$currencyPLN = new Currency('PLN');

// Example usage 1

$exchange = MoneyCurrencyExchange::fromSellOperation(
    new Money($currencyEUR, 100),
    SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60),
);

echo sprintf(
    'Sold from "%s %.2f" to "%s %.2f" with rate "%.4f"',
    $exchange->fromMoney->currency->code,
    $exchange->fromMoney->amount,
    $exchange->toMoney->currency->code,
    $exchange->toMoney->amount,
    $exchange->rate->rate,
) . PHP_EOL;

$invertExchange = MoneyCurrencyExchange::fromSellOperation(
    new Money($currencyPLN, 460.0),
    SellRate::asSellRate($currencyEUR, $currencyPLN, 4.60)->invert(),
);

echo sprintf(
    'Sold from "%s %.2f" to "%s %.2f" with rate "%.4f"',
    $invertExchange->fromMoney->currency->code,
    $invertExchange->fromMoney->amount,
    $invertExchange->toMoney->currency->code,
    $invertExchange->toMoney->amount,
    $invertExchange->rate->rate,
) . PHP_EOL;

// -- Result --
// Sold from "EUR 100.00" to "PLN 460.00" with rate "4.6000"
// Sold from "PLN 460.00" to "EUR 100.00" with rate "0.2174"

// Example usage 2

$exchange = MoneyCurrencyExchange::fromBuyOperation(
    new Money($currencyEUR, 100),
    BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50),
);

echo sprintf(
    'Bought from "%s %.2f" to "%s %.2f" with rate "%.4f"',
    $exchange->fromMoney->currency->code,
    $exchange->fromMoney->amount,
    $exchange->toMoney->currency->code,
    $exchange->toMoney->amount,
    $exchange->rate->rate,
) . PHP_EOL;

$invertExchange = MoneyCurrencyExchange::fromBuyOperation(
    new Money($currencyPLN, 450.00),
    BuyRate::asBuyRate($currencyEUR, $currencyPLN, 4.50)->invert(),
);

echo sprintf(
    'Bought from "%s %.2f" to "%s %.2f" with rate "%.4f"',
    $invertExchange->fromMoney->currency->code,
    $invertExchange->fromMoney->amount,
    $invertExchange->toMoney->currency->code,
    $invertExchange->toMoney->amount,
    $invertExchange->rate->rate,
) . PHP_EOL;

// -- Result --
// Bought from "EUR 100.00" to "PLN 450.00" with rate "4.5000"
// Bought from "PLN 450.00" to "EUR 100.00" with rate "0.2222"
```
