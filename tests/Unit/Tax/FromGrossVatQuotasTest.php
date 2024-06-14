<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
use Nauta\Domain\Tax\BaseVatQuota;
use Nauta\Domain\Tax\FromGrossVatQuotas;

final class FromGrossVatQuotasTest extends AbstractBaseVatQuotaTestCase
{
    public function testCreateFromGrossVatQuotas(): void
    {
        $expectedVat = VatValue::fromNumeric(23);
        $expectedNet = NetValue::fromNumeric(100);

        $actual = $this->createInstance(123, VatRateValue::fromNumeric(.23));

        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
        self::assertTrue($expectedNet->isEqualTo($actual->getNet()));
    }

    public function testWithRate(): void
    {
        $instance = $this->createInstance(100, VatRateValue::fromNumeric(.23));

        $actual = $instance->withRate(VatRateValue::fromNumeric(.1));

        $expectedNet = NetValue::fromNumeric(90.91);
        $expectedGross = GrossValue::fromNumeric(100);
        $expectedRate = VatRateValue::fromNumeric(.1);
        $expectedVat = VatValue::fromNumeric(9.09);

        self::assertNotSame($instance, $actual);
        self::assertTrue($expectedNet->isEqualTo($actual->getNet()));
        self::assertTrue($expectedGross->isEqualTo($actual->getGross()));
        self::assertTrue($expectedRate->isEqualTo($actual->getRate()));
        self::assertTrue($expectedVat->isEqualTo($actual->getVat()));
    }

    public function testIsEqualTo(): void
    {
        $expectedNet = BaseVatQuota::fromNet(
            NetValue::fromNumeric(100),
            VatRateValue::fromNumeric(.23),
        );

        $actualGross = BaseVatQuota::fromGross(
            GrossValue::fromNumeric(123),
            VatRateValue::fromNumeric(.23),
        );

        self::assertTrue($expectedNet->isEqualTo($actualGross));
    }

    protected function createInstance(float $value, VatRateValue $rate): FromGrossVatQuotas
    {
        return FromGrossVatQuotas::fromGrossVatQuotas(GrossValue::fromNumeric($value), $rate);
    }
}
