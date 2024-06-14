### Tax
Basic VAT calculations

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
```

@todo add example of add & subtract

inspired by: https://www.streamsoft.pl/blog-it/oop-in-action/
