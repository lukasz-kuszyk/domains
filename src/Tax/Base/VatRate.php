<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\Base;

use Brick\Math\BigDecimal;
use Nauta\Domain\Contracts\Common\IsRate;
use Nauta\Domain\Contracts\Logic\IsSelfComparable;
use Nauta\Domain\Tax\Exception\NegativeVatRateException;

class VatRate implements IsRate, IsSelfComparable
{
    /**
     * @throws NegativeVatRateException
     */
    private function __construct(
        private readonly float $value,
    ) {
        if (BigDecimal::of($this->value)->isNegative()) {
            throw new NegativeVatRateException();
        }
    }

    /**
     * @throws NegativeVatRateException
     */
    public static function fromFraction(float $value): VatRate
    {
        return new self($value);
    }

    public static function zero(): VatRate
    {
        /** @var VatRate|null $zero */
        static $zero;

        if (null === $zero) {
            $zero = VatRate::fromFraction(0);
        }

        return $zero;
    }

    public function isEqualTo(VatRate $value): bool
    {
        return BigDecimal::of($value->getRateAsFraction())->isEqualTo($this->getRateAsFraction());
    }

    public function getRateAsPercentage(): float
    {
        return BigDecimal::of($this->getRateAsFraction())
            ->multipliedBy(100)
            ->toFloat();
    }

    public function getRateAsFraction(): float
    {
        return $this->value;
    }
}
