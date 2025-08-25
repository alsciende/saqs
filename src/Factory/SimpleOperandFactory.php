<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Factory;

use LuminescentGem\Saqs\Model\OperandInterface;
use LuminescentGem\Saqs\Model\SimpleOperand;

class SimpleOperandFactory implements OperandFactoryInterface
{
    public function fromValue(int|string $value): OperandInterface
    {
        if (is_int($value)) {
            $value = (string) $value;
        }

        return SimpleOperand::from($value);
    }

    public function allValues(): array
    {
        return SimpleOperand::cases();
    }
}
