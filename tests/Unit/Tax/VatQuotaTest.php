<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\Vat;
use Nauta\Domain\Tax\Base\VatRate;
use Nauta\Domain\Tax\GrossVatQuota;
use Nauta\Domain\Tax\NetVatQuota;
use PHPUnit\Framework\TestCase;

class VatQuotaTest extends TestCase
{
    public function testFromGrossAndRate(): void
    {
        $result = GrossVatQuota::fromGrossAndRate(
            Gross::fromNumeric(123),
            VatRate::fromFraction(.23),
        );

        self::assertTrue(
            $result->getNet()->isEqualTo(Net::fromNumeric(100))
        );

        self::assertTrue(
            $result->getVat()->isEqualTo(Vat::fromNumeric(23))
        );

        self::assertTrue(
            $result->getGross()->isEqualTo(Gross::fromNumeric(123))
        );

        self::assertTrue(
            $result->getRate()->isEqualTo(VatRate::fromFraction(.23))
        );
    }

    public function testFromNetAndRate(): void
    {
        $result = NetVatQuota::fromNetAndRate(
            Net::fromNumeric(100),
            VatRate::fromFraction(.23),
        );

        self::assertTrue(
            $result->getNet()->isEqualTo(Net::fromNumeric(100))
        );

        self::assertTrue(
            $result->getVat()->isEqualTo(Vat::fromNumeric(23))
        );

        self::assertTrue(
            $result->getGross()->isEqualTo(Gross::fromNumeric(123))
        );

        self::assertTrue(
            $result->getRate()->isEqualTo(VatRate::fromFraction(.23))
        );
    }
}
