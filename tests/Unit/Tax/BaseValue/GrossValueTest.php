<?php

declare(strict_types=1);

namespace Unit\Tax\BaseValue;

use Nauta\Domain\Tax\BaseValue\BaseValue;
use Nauta\Domain\Tax\BaseValue\GrossValue;
use Nauta\Domain\Tests\Unit\Tax\BaseValue\AbstractBaseValueTest;

class GrossValueTest extends AbstractBaseValueTest
{
    protected function createInstance(int $value): BaseValue
    {
        return GrossValue::fromNumeric($value);
    }
}
