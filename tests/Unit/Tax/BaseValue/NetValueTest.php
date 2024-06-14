<?php

declare(strict_types=1);

namespace Unit\Tax\BaseValue;

use Nauta\Domain\Tax\BaseValue\BaseValue;
use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
use Nauta\Domain\Tests\Unit\Tax\BaseValue\AbstractBaseValueTest;

class NetValueTest extends AbstractBaseValueTest
{
    protected function createInstance(int $value): BaseValue
    {
        return NetValue::fromNumeric($value);
    }

    public function testCreateFromGross(): void
    {
        $gross = GrossValue::fromNumeric(123);
        $vat = VatValue::fromNumeric(23);

        $actual = NetValue::fromGross($gross, $vat);

        self::assertTrue(NetValue::fromNumeric(100)->isEqualTo($actual));
    }

    public function testAdd(): void
    {
        $vat = VatValue::fromNumeric(23);

        $actual = NetValue::fromNumeric(100)->add($vat);

        self::assertTrue(GrossValue::fromNumeric(123)->isEqualTo($actual));
    }
}
