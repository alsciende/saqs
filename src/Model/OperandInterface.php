<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

interface OperandInterface
{
    public function getValue(): string;
}
