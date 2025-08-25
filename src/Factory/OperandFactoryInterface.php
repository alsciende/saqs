<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Factory;

use LuminescentGem\Saqs\Model\OperandInterface;

interface OperandFactoryInterface
{
    public function fromValue(int|string $value): OperandInterface;

    /**
     * @return list<OperandInterface>
     */
    public function allValues(): array;
}
