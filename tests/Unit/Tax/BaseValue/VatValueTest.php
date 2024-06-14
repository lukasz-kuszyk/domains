<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\BaseValue;

use Nauta\Domain\Tax\BaseValue\BaseValue;
use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;

final class VatValueTest extends AbstractBaseValueTestCase
{
    protected function createInstance(int $value): BaseValue
    {
        return VatValue::fromNumeric($value);
    }

    public function testCreateFromNet(): void
    {
        $net = NetValue::fromNumeric(100);
        $rate = VatRateValue::fromNumeric(.23);

        $actual = VatValue::fromNet($net, $rate);

        self::assertTrue(VatValue::fromNumeric(23)->isEqualTo($actual));
    }

    public function testCreateFromGross(): void
    {
        $gross = GrossValue::fromNumeric(123);
        $rate = VatRateValue::fromNumeric(.23);

        $actual = VatValue::fromGross($gross, $rate);

        self::assertTrue(VatValue::fromNumeric(23)->isEqualTo($actual));
    }
}
