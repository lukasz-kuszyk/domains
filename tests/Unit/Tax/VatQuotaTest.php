<?php

declare(strict_types=1);

namespace Nauta\Domain\Tests\Unit\Tax;

use Nauta\Domain\Tax\Base\Gross;
use Nauta\Domain\Tax\Base\Net;
use Nauta\Domain\Tax\Base\VatRate;
use Nauta\Domain\Tax\GrossVatQuota;
use Nauta\Domain\Tax\NetVatQuota;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class VatQuotaTest extends TestCase
{
    public static function provideEqualToAsTrue(): \Generator
    {
        yield [123, 100, .23];
        yield [0, 0, .0];
        yield [0, 0, .23];
        yield [100, 100, .0];
    }

    #[DataProvider('provideEqualToAsTrue')]
    public function testEqualToAsTrue(int $gross, int $net, float $rate): void
    {
        $grossQuota = GrossVatQuota::fromGrossAndRate(Gross::fromNumeric($gross), VatRate::fromFraction($rate));
        $netQuota = NetVatQuota::fromNetAndRate(Net::fromNumeric($net), VatRate::fromFraction($rate));

        self::assertTrue($grossQuota->isEqualTo($netQuota));
    }

    public static function provideEqualToAsFalse(): \Generator
    {
        yield [110, .10, 110, .20];
        yield [120, .10, 140, .10];
        yield [0, 0, 20, 0];
        yield [20, 0, 0, 0];
    }

    #[DataProvider('provideEqualToAsFalse')]
    public function testEqualToAsFalse(int $gross, float $grossRate, int $net, float $netRate): void
    {
        $grossQuota = GrossVatQuota::fromGrossAndRate(Gross::fromNumeric($gross), VatRate::fromFraction($grossRate));
        $netQuota = NetVatQuota::fromNetAndRate(Net::fromNumeric($net), VatRate::fromFraction($netRate));

        self::assertFalse($grossQuota->isEqualTo($netQuota));
    }
}
