<?php

declare(strict_types=1);

namespace Nauta\Domain\Contracts\Common;

interface IsAmountWhole extends IsAmount
{
    public function getAmountAsNumber(): int;
}
