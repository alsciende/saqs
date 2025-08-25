<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Exception;

class BadOperandException extends SyntaxException
{
    public function __construct(
        public string $value,
        ?\Throwable $previous = null
    ) {
        parent::__construct(previous: $previous);
    }
}
