<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
use Nauta\Domain\Tax\BaseVatQuota;
use Nauta\Domain\Tax\FromNetVatQuotas;

final class FromNetVatQuotasTest extends AbstractBaseVatQuotaTestCase
{
    public function testCreateFromNetVatQuotas(): void
    {
        $expectedVat = VatValue::fromNumeric(23);
        $expectedGross = GrossValue::fromNumeric(123);

        $actual = $this->createInstance(100, VatRateValue::fromNumeric(.23));

        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
        self::assertTrue($expectedGross->isEqualTo($actual->getGross()));
    }

    public function testWithRate(): void
    {
        $instance = $this->createInstance(100, VatRateValue::fromNumeric(.23));

        $actual = $instance->withRate(VatRateValue::fromNumeric(.1));

        $expectedNet = NetValue::fromNumeric(100);
        $expectedGross = GrossValue::fromNumeric(110);
        $expectedRate = VatRateValue::fromNumeric(.1);
        $expectedVat = VatValue::fromNumeric(10);

        self::assertNotSame($instance, $actual);
        self::assertTrue($expectedNet->isEqualTo($actual->getNet()));
        self::assertTrue($expectedGross->isEqualTo($actual->getGross()));
        self::assertTrue($expectedRate->isEqualTo($actual->getRate()));
        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
    }

    public function testIsEqualTo(): void
    {
        $expectedGross = BaseVatQuota::fromGross(
            GrossValue::fromNumeric(123),
            VatRateValue::fromNumeric(.23),
        );

        $actualNet = BaseVatQuota::fromNet(
            NetValue::fromNumeric(100),
            VatRateValue::fromNumeric(.23),
        );

        self::assertTrue($expectedGross->isEqualTo($actualNet));
    }

    protected function createInstance(float $value, VatRateValue $rate): FromNetVatQuotas
    {
        return FromNetVatQuotas::fromNetVatQuotas(NetValue::fromNumeric($value), $rate);
    }
}
