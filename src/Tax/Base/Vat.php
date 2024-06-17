<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\Base;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Nauta\Domain\Contracts\Common\IsAmount;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;

class Vat implements IsAmount, IsSelfComparable
{
    private function __construct(
        private readonly float|int $value,
    ) {
    }

    public static function fromNumeric(float|int $value): Vat
    {
        return new self($value);
    }

    public static function fromNetAndRate(Net $net, VatRate $rate): Vat
    {
        return self::fromNumeric(self::calcFromNet($net, $rate)->toFloat());
    }

    public static function fromGrossAndRate(Gross $gross, VatRate $rate): Vat
    {
        return self::fromNumeric(self::calcFromGross($gross, $rate)->toFloat());
    }

    public function isEqualTo(Vat $value): bool
    {
        return BigDecimal::of($value->getAmountAsNumber())->isEqualTo($this->getAmountAsNumber());
    }

    public function getAmountAsNumber(): float|int
    {
        return $this->value;
    }

    private static function calcFromGross(Gross $gross, VatRate $rate): BigDecimal
    {
        $ratePercentPlusOne = BigDecimal::of($rate->getRateAsFraction())
            ->plus(BigDecimal::one());

        return BigDecimal::of($gross->getAmountAsNumber())
            ->multipliedBy($rate->getRateAsFraction())
            ->dividedBy($ratePercentPlusOne, 2, RoundingMode::HALF_UP);
    }

    private static function calcFromNet(Net $net, VatRate $rate): BigDecimal
    {
        return BigDecimal::of($rate->getRateAsFraction())
            ->multipliedBy($net->getAmountAsNumber())
            ->toScale(2, RoundingMode::HALF_UP);
    }
}
