<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\Base;

use Brick\Math\BigDecimal;
use Nauta\Domain\Contracts\Common\IsAmount;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;

class Gross implements IsAmount, IsSelfComparable
{
    private function __construct(
        private readonly float|int $value,
    ) {
    }

    public static function fromNumeric(float|int $value): Gross
    {
        return new self($value);
    }

    final public static function fromNetAndVat(Net $net, Vat $vat): Gross
    {
        return self::fromNumeric($net->add($vat)->getAmountAsNumber());
    }

    final public function subtract(Vat $vat): Net
    {
        $value = BigDecimal::of($this->getAmountAsNumber())
            ->minus($vat->getAmountAsNumber())
            ->toFloat();

        return Net::fromNumeric($value);
    }

    public function isEqualTo(Gross $value): bool
    {
        return BigDecimal::of($value->getAmountAsNumber())->isEqualTo($this->getAmountAsNumber());
    }

    public function getAmountAsNumber(): float|int
    {
        return $this->value;
    }
}
