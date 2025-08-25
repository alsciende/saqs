<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Parser;

use LuminescentGem\Saqs\Exception\BadConditionException;
use LuminescentGem\Saqs\Exception\BadOperandException;
use LuminescentGem\Saqs\Exception\BadOperatorException;
use LuminescentGem\Saqs\Exception\SyntaxException;
use LuminescentGem\Saqs\Factory\OperandFactoryInterface;
use LuminescentGem\Saqs\Factory\OperatorFactoryInterface;
use LuminescentGem\Saqs\Factory\SimpleOperandFactory;
use LuminescentGem\Saqs\Factory\SimpleOperatorFactory;
use LuminescentGem\Saqs\Model\Condition;
use LuminescentGem\Saqs\Model\ConditionCollection;
use LuminescentGem\Saqs\Model\OperatorInterface;

class Parser
{
    private string $pattern;

    private OperatorFactoryInterface $operatorFactory;

    private OperandFactoryInterface $operandFactory;

    /**
     * @param array<string, mixed> $context
     */
    public function __construct(array $context = [])
    {
        if (isset($context['operator_factory']) && $context['operator_factory'] instanceof OperatorFactoryInterface) {
            $this->operatorFactory = $context['operator_factory'];
        } else {
            $this->operatorFactory = new SimpleOperatorFactory();
        }

        if (isset($context['operand_factory']) && $context['operand_factory'] instanceof OperandFactoryInterface) {
            $this->operandFactory = $context['operand_factory'];
        } else {
            $this->operandFactory = new SimpleOperandFactory();
        }

        $this->pattern = $this->generatePattern();
    }

    /**
     * Decodes a query string into a ConditionCollection which contains all the query elements.
     *
     * @TODO 1st match_all (?:(?<operand>\w)(?<operator>[:!<>]))?(?<value>(?:\w+|(?:"[^"]+"))(?:\|(?:\w+|(?:"[^"]+")))*)
     * @TODO 2nd match_all on each 'value' : (\w+)|(?:"([^"]+)")
     *
     * @param string $query The expression in the form of advanced syntax to evaluate
     */
    public function decode(string $query): ConditionCollection
    {
        // Match all conditions
        preg_match_all($this->pattern, $query, $matches);

        // Process the matches
        $conditions = [];
        foreach ($matches[0] as $i => $match) {
            try {
                $conditions[] = match (false) {
                    empty($matches[1][$i]) => $this->parseCondition($matches[1][$i]),
                    empty($matches[2][$i]) => $this->parseCondition($matches[2][$i]),
                    empty($matches[3][$i]) => $this->parseCondition('_:' . $matches[3][$i]),
                    empty($matches[4][$i]) => $this->parseCondition('_:' . $matches[4][$i]),
                    false => throw new \LogicException('Empty query match!'),
                };
            } catch (SyntaxException $e) {
                throw new BadConditionException($match, previous: $e);
            }
        }

        return ConditionCollection::fromConditions($conditions);
    }

    private function generatePattern(): string
    {
        $operators = implode(
            '',
            array_map(
                fn (OperatorInterface $operator): string => $operator->getValue(),
                $this->operatorFactory->allValues()
            )
        );

        $quotedString = '"(?:[^"\\\\]|\\\\.)*"';

        return "/
            (\w[{$operators}]{$quotedString})     # char + operator + quoted string
            |
            (\w[{$operators}][\w-]+)               # char + operator + word
            |
            ({$quotedString})                   # standalone quoted string
            |
            ([\w-]+)                             # standalone word
        /x";
    }

    /**
     * Decode a query part into a Condition.
     *
     * @throws SyntaxException
     */
    private function parseCondition(string $condition): Condition
    {
        $operandValue = substr($condition, 0, 1);
        $operatorValue = substr($condition, 1, 1);
        $value = substr($condition, 2, strlen($condition) - 2);

        // Unquote value if needed
        if (str_starts_with($value, '"') && str_ends_with($value, '"')) {
            $value = substr($value, 1, -1);
        }

        try {
            $operand = $this->operandFactory->fromValue($operandValue);
        } catch (\Throwable $e) {
            throw new BadOperandException($operatorValue, previous: $e);
        }

        try {
            $operator = $this->operatorFactory->fromValue($operatorValue);
        } catch (\Throwable $e) {
            throw new BadOperatorException($operatorValue, $operand->getValue(), previous: $e);
        }

        return new Condition($value, $operand->getValue(), $operator);
    }
}
