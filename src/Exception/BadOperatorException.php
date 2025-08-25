<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Exception;

class BadOperatorException extends SyntaxException
{
    public function __construct(
        public string $value,
        public string $operand,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }
}
