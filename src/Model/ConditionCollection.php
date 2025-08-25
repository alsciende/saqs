<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

/**
 * A collection of Condition objects.
 *
 * @implements \IteratorAggregate<int, Condition>
 */
class ConditionCollection implements \JsonSerializable, \IteratorAggregate
{
    /**
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * @param list<Condition> $conditions
     */
    public static function fromConditions(array $conditions): self
    {
        $search = new self();
        foreach ($conditions as $condition) {
            $search->addCondition($condition);
        }

        return $search;
    }

    public function addCondition(Condition $condition): void
    {
        $this->conditions[] = $condition;
    }

    /**
     * @return list<Condition>
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function jsonSerialize(): mixed
    {
        return $this->conditions;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->conditions);
    }
}
