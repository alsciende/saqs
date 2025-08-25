<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Validator;

use LuminescentGem\Saqs\Model\Condition;

interface ConditionValidatorInterface
{
    /**
     * @return list<string> An array of error messages, empty if the condition is valid
     */
    public function validateCondition(Condition $condition): array;
}
