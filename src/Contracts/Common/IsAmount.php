<?php

declare(strict_types=1);

namespace Nauta\Domain\Contracts\Common;

interface IsAmount
{
    public function getAmountAsNumber(): float|int;
}
