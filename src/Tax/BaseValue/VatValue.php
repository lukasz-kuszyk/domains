<?php

declare(strict_types=1);

namespace Nauta\Domain\Tax\BaseValue;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class VatValue extends BaseValue
{
    final public static function fromNet(NetValue $net, VatRateValue $rate): VatValue
    {
        return self::fromBigDecimal(self::calcFromNet($net, $rate));
    }

    final public static function fromGross(GrossValue $gross, VatRateValue $rate): VatValue
    {
        return self::fromBigDecimal(self::calcFromGross($gross, $rate));
    }

    private static function calcFromGross(GrossValue $gross, VatRateValue $rate): BigDecimal
    {
        $ratePercent = $rate->getPercent();
        $ratePercentPlusOne = $ratePercent->plus($ratePercent::one());
        $rawGross = $gross->toBigDecimal();

        return $rawGross->multipliedBy($ratePercent)->dividedBy($ratePercentPlusOne, 2, RoundingMode::HALF_UP);
    }

    private static function calcFromNet(NetValue $net, VatRateValue $rate): BigDecimal
    {
        $ratePercent = $rate->getPercent();
        $rawNet = $net->toBigDecimal();

        return $rawNet->multipliedBy($ratePercent)->toScale(2, RoundingMode::HALF_UP);
    }
}
