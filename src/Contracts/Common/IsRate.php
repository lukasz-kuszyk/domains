<?php

declare(strict_types=1);

namespace Nauta\Domain\Contracts\Common;

interface IsRate
{
    /**
     * @return float 23% Rate will be returned as (float) 23.0
     */
    public function getRateAsPercentage(): float;

    /**
     * @return float 23% Rate will be returned as (float) 0.23
     */
    public function getRateAsFraction(): float;
}
