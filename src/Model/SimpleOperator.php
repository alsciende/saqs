<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

enum SimpleOperator: string implements OperatorInterface
{
    case EQ = ':';
    case NE = '!';
    case LT = '<';
    case GT = '>';

    public function getValue(): string
    {
        return $this->value;
    }
}
