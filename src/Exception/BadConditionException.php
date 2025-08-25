<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Exception;

class BadConditionException extends SyntaxException
{
    public function __construct(
        public string $query,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }
}
