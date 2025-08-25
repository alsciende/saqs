<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Exception;

class InvalidConditionException extends SyntaxException
{
    /**
     * @param list<string> $errors
     */
    public function __construct(
        public array $errors,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }
}
