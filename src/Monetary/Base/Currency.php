<?php

declare(strict_types=1);

namespace Nauta\Domain\Monetary\Base;

use Nauta\Domain\Contracts\Logic\IsSelfComparable;
use Nauta\Domain\Contracts\Monetary\IsCurrency;

class Currency implements IsCurrency, IsSelfComparable
{
    public function __construct(
        public readonly string $code,
    ) {
    }

    public function getCurrencyCode(): string
    {
        return $this->code;
    }

    public function isEqualTo(IsCurrency $currency): bool
    {
        return $currency instanceof IsSelfComparable
            && $currency->getCurrencyCode() === $this->getCurrencyCode();
    }
}
