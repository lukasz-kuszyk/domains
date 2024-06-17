<?php

declare(strict_types=1);

namespace Nauta\Domain\Contracts\Monetary;

interface IsCurrency
{
    public function getCurrencyCode(): string;
}
