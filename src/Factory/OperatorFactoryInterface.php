<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Factory;

use LuminescentGem\Saqs\Model\OperatorInterface;

interface OperatorFactoryInterface
{
    public function fromValue(int|string $value): OperatorInterface;

    /**
     * @return list<OperatorInterface>
     */
    public function allValues(): array;
}
