<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax\BaseValue;

use Brick\Math\BigDecimal;
use Nauta\Domain\Tax\BaseValue\BaseValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;

class VatRateValueTest extends AbstractBaseValueTest
{
    protected function createInstance(int $value): BaseValue
    {
        return VatRateValue::fromNumeric($value);
    }

    public function testGetPercent(): void
    {
        $percent = VatRateValue::fromNumeric(0.5)->getPercent();

        self::assertTrue(BigDecimal::of(0.5)->isEqualTo($percent));
    }
}
