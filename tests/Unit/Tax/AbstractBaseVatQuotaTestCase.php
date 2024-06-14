<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
use Nauta\Domain\Tax\BaseVatQuota;
use PHPUnit\Framework\TestCase;

abstract class AbstractBaseVatQuotaTestCase extends TestCase
{
    abstract protected function createInstance(float $value, VatRateValue $rate): BaseVatQuota;

    public function testWithNet(): void
    {
        $instance = $this->createInstance(100, VatRateValue::fromNumeric(.23));

        $actual = $instance->withNet(NetValue::fromNumeric(200));

        $expectedNet = NetValue::fromNumeric(200);
        $expectedGross = GrossValue::fromNumeric(246);
        $expectedRate = VatRateValue::fromNumeric(.23);
        $expectedVat = VatValue::fromNumeric(46);

        self::assertNotSame($instance, $actual);
        self::assertTrue($expectedNet->isEqualTo($actual->getNet()));
        self::assertTrue($expectedGross->isEqualTo($actual->getGross()));
        self::assertTrue($expectedRate->isEqualTo($actual->getRate()));
        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
    }

    public function testWithGross(): void
    {
        $instance = $this->createInstance(100, VatRateValue::fromNumeric(.23));

        $actual = $instance->withGross(GrossValue::fromNumeric(246));

        $expectedNet = NetValue::fromNumeric(200);
        $expectedGross = GrossValue::fromNumeric(246);
        $expectedRate = VatRateValue::fromNumeric(.23);
        $expectedVat = VatValue::fromNumeric(46);

        self::assertNotSame($instance, $actual);
        self::assertTrue($expectedNet->isEqualTo($actual->getNet()));
        self::assertTrue($expectedGross->isEqualTo($actual->getGross()));
        self::assertTrue($expectedRate->isEqualTo($actual->getRate()));
        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
    }
}
