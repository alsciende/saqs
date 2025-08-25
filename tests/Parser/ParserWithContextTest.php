<?php

declare(strict_types=1);

namespace LuminescentGem\SaqsTest\Parser;

use LuminescentGem\Saqs\Exception\BadConditionException;
use LuminescentGem\Saqs\Factory\OperandFactoryInterface;
use LuminescentGem\Saqs\Factory\OperatorFactoryInterface;
use LuminescentGem\Saqs\Model\ConditionCollection;
use LuminescentGem\Saqs\Model\OperandInterface;
use LuminescentGem\Saqs\Model\OperatorInterface;
use LuminescentGem\Saqs\Parser\Parser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class Operator implements OperatorInterface
{
    public const array VALID_VALUES = [':'];

    public function __construct(
        private string $value
    ) {
        if (! in_array($value, self::VALID_VALUES, true)) {
            throw new \InvalidArgumentException("Invalid operator: {$value}");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

final class OperatorFactory implements OperatorFactoryInterface
{
    public function fromValue(int|string $value): OperatorInterface
    {
        return new Operator((string) $value);
    }

    public function allValues(): array
    {
        return array_map(
            fn ($v) => new Operator($v),
            Operator::VALID_VALUES
        );
    }
}

final class Operand implements OperandInterface
{
    public const array VALID_VALUES = ['c'];

    public function __construct(
        private string $value
    ) {
        if (! in_array($value, self::VALID_VALUES, true)) {
            throw new \InvalidArgumentException("Invalid operand: {$value}");
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}

final class OperandFactory implements OperandFactoryInterface
{
    public function fromValue(int|string $value): OperandInterface
    {
        return new Operand((string) $value);
    }

    public function allValues(): array
    {
        return array_map(
            fn ($v) => new Operand($v),
            Operand::VALID_VALUES
        );
    }
}

class ParserWithContextTest extends TestCase
{
    /**
     * @return array<array{string, ?class-string<\Throwable>}>
     */
    public static function parserProvider(): array
    {
        return [
            ['c:Paris', null],
            ['t:Paris', BadConditionException::class],
            ['c!Paris', BadConditionException::class],
        ];
    }

    /**
     * @param ?class-string<\Throwable> $exception
     */
    #[DataProvider('parserProvider')]
    public function testParser(string $query, ?string $exception): void
    {
        $parser = new Parser([
            'operator_factory' => new OperatorFactory(),
            'operand_factory' => new OperandFactory(),
        ]);

        if ($exception !== null) {
            $this->expectException($exception);
        }

        self::assertInstanceOf(ConditionCollection::class, $parser->decode($query));
    }
}
