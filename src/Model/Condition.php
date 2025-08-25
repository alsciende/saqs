<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

class Condition implements \JsonSerializable
{
    public function __construct(
        private string $value,
        private string $operand,
        private OperatorInterface $operator,
    ) {
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getOperand(): string
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
            'operand' => $this->operand,
            'operator' => $this->operator->getValue(),
            'value' => $this->value,
        ];
    }
}
