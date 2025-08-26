<?php

declare(strict_types=1);

namespace LuminescentGem\SaqsTest\Parser;

use LuminescentGem\Saqs\Model\Condition;
use LuminescentGem\Saqs\Model\ConditionCollection;
use LuminescentGem\Saqs\Parser\Parser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @return list<array{string, string}>
     */
    public static function parserProvider(): array
    {
        return [
            ['c:Paris', '[{"operand":"c","operator":":","value":"Paris"}]'],
            ['c:New-York', '[{"operand":"c","operator":":","value":"New-York"}]'],
            ['c:"New York"', '[{"operand":"c","operator":":","value":"New York"}]'],
            ['"New York"', '[{"operand":"_","operator":":","value":"New York"}]'],
            ['New-York', '[{"operand":"_","operator":":","value":"New-York"}]'],
            ['c!London', '[{"operand":"c","operator":"!","value":"London"}]'],
            ['y>1950', '[{"operand":"y","operator":">","value":"1950"}]'],
            ['y<2000', '[{"operand":"y","operator":"<","value":"2000"}]'],
            ['y!1999', '[{"operand":"y","operator":"!","value":"1999"}]'],
            ['c:Paris y!1999', '[{"operand":"c","operator":":","value":"Paris"},{"operand":"y","operator":"!","value":"1999"}]'],
        ];
    }

    #[DataProvider('parserProvider')]
    public function testParser(string $query, string $expected): void
    {
        $parser = new Parser();
        $collection = $parser->decode($query);

        // testing type
        self::assertInstanceOf(ConditionCollection::class, $collection);
        foreach ($collection as $condition) {
            self::assertInstanceOf(Condition::class, $condition);
        }

        // testing value
        self::assertEquals(
            $expected,
            json_encode($collection, JSON_THROW_ON_ERROR)
        );
    }
}
