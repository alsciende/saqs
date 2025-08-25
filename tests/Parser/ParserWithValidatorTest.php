<?php

declare(strict_types=1);

namespace LuminescentGem\SaqsTest\Parser;

use LuminescentGem\Saqs\Exception\BadConditionException;
use LuminescentGem\Saqs\Model\Condition;
use LuminescentGem\Saqs\Model\ConditionCollection;
use LuminescentGem\Saqs\Parser\Parser;
use LuminescentGem\Saqs\Validator\ConditionValidatorInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class Validator implements ConditionValidatorInterface
{
    public function validateCondition(Condition $condition): array
    {
        if (! in_array($condition->getOperand()->getValue(), ['p'])
         && in_array($condition->getOperator()->getValue(), ['<', '>'])) {
            return ['Numeric operator with a non-numeric operand.'];
        }

        return [];
    }
}

class ParserWithValidatorTest extends TestCase
{
    /**
     * @return array<array{string, ?class-string<\Throwable>}>
     */
    public static function parserProvider(): array
    {
        return [
            ['c:Paris', null],
            ['p<1000', null],
            ['c>Paris', BadConditionException::class],
        ];
    }

    /**
     * @param ?class-string<\Throwable> $exception
     */
    #[DataProvider('parserProvider')]
    public function testParser(string $query, ?string $exception): void
    {
        $parser = new Parser(
            conditionValidator: new Validator()
        );

        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertInstanceOf(ConditionCollection::class, $parser->decode($query));
    }
}
