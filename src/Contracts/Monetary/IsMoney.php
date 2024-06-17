<?php

declare(strict_types=1);

namespace Nauta\Domain\Contracts\Monetary;

use Nauta\Domain\Contracts\Common\IsAmount;

interface IsMoney extends IsAmount, IsCurrency
{
    public function getCurrency(): IsCurrency;
}
