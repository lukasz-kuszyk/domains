<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
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

    protected function createInstance(float $value, VatRateValue $rate): FromGrossVatQuotas
    {
        return FromGrossVatQuotas::fromGrossVatQuotas(GrossValue::fromNumeric($value), $rate);
    }
}
