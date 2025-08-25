<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Factory;

use LuminescentGem\Saqs\Model\OperatorInterface;
use LuminescentGem\Saqs\Model\SimpleOperator;

class SimpleOperatorFactory implements OperatorFactoryInterface
{
    public function fromValue(int|string $value): OperatorInterface
    {
        if (is_int($value)) {
            $value = (string) $value;
        }

        return SimpleOperator::from($value);
    }

    public function allValues(): array
    {
        return SimpleOperator::cases();
    }
}
