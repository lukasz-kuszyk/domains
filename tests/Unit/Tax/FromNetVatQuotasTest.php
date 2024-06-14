<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tax\BaseValue\NetValue;
use Nauta\Domain\Tax\BaseValue\VatRateValue;
use Nauta\Domain\Tax\BaseValue\VatValue;
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

    protected function createInstance(float $value, VatRateValue $rate): FromNetVatQuotas
    {
        return FromNetVatQuotas::fromNetVatQuotas(NetValue::fromNumeric($value), $rate);
    }
}
