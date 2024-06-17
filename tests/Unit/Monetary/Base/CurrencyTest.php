<?php

declare(strict_types=1);

namespace Monetary\Base;

use Nauta\Domain\Monetary\Base\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function testGetCurrencyCode(): void
    {
        self::assertSame((new Currency('A'))->getCurrencyCode(), 'A');
    }

    public function testIsEqualToAsTrue(): void
    {
        self::assertTrue((new Currency('A'))->isEqualTo(new Currency('A')));
    }

    public function testIsEqualToAsFalse(): void
    {
        self::assertFalse((new Currency('A'))->isEqualTo(new Currency('B')));
    }
}
