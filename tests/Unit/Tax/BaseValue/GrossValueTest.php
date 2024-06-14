<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\BaseValue;

use Nauta\Domain\Tax\BaseValue\BaseValue;
use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatValue;

final class GrossValueTest extends AbstractBaseValueTestCase
{
    protected function createInstance(int $value): BaseValue
    {
        return GrossValue::fromNumeric($value);
    }

    public function testCreateFromNet(): void
    {
        $net = NetValue::fromNumeric(100);
        $vat = VatValue::fromNumeric(23);

        $actual = GrossValue::fromNet($net, $vat);

        self::assertTrue(GrossValue::fromNumeric(123)->isEqualTo($actual));
    }

    public function testSubtract(): void
    {
        $vat = VatValue::fromNumeric(23);

        $actual = GrossValue::fromNumeric(123)->subtract($vat);

        self::assertTrue(NetValue::fromNumeric(100)->isEqualTo($actual));
    }
}
