<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

class Condition implements \JsonSerializable
{
    public function __construct(
        private OperandInterface $operand,
        private OperatorInterface $operator,
        private string $value,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOperand(): OperandInterface
    {
        return $this->operand;
    }

    public function getOperator(): OperatorInterface
    {
        return $this->operator;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'operand' => $this->operand->getValue(),
            'operator' => $this->operator->getValue(),
            'value' => $this->value,
        ];
    }
}
