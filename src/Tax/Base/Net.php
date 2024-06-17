<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\Base;

use Brick\Math\BigDecimal;
use Nauta\Domain\Contracts\Common\IsAmount;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;

class Net implements IsAmount, IsSelfComparable
{
    private function __construct(
        private readonly float|int $value,
    ) {
    }

    public static function fromNumeric(float|int $value): Net
    {
        return new self($value);
    }

    final public static function fromGrossAndVat(Gross $gross, Vat $vat): Net
    {
        return self::fromNumeric($gross->subtract($vat)->getAmountAsNumber());
    }

    final public function add(Vat $vat): Gross
    {
        $value = BigDecimal::of($this->getAmountAsNumber())
            ->plus($vat->getAmountAsNumber())
            ->toFloat();

        return Gross::fromNumeric($value);
    }

    public function isEqualTo(Net $value): bool
    {
        return BigDecimal::of($value->getAmountAsNumber())->isEqualTo($this->getAmountAsNumber());
    }

    public function getAmountAsNumber(): float|int
    {
        return $this->value;
    }
}
