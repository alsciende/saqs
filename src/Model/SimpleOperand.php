<?php

declare(strict_types=1);

namespace LuminescentGem\Saqs\Model;

enum SimpleOperand: string implements OperandInterface
{
    case UNDERSCORE = '_';
    case A = 'a';
    case B = 'b';
    case C = 'c';
    case D = 'd';
    case E = 'e';
    case F = 'f';
    case G = 'g';
    case H = 'h';
    case I = 'i';
    case J = 'j';
    case K = 'k';
    case L = 'l';
    case M = 'm';
    case N = 'n';
    case O = 'o';
    case P = 'p';
    case Q = 'q';
    case R = 'r';
    case S = 's';
    case T = 't';
    case U = 'u';
    case V = 'v';
    case W = 'w';
    case X = 'x';
    case Y = 'y';
    case Z = 'z';

    public function getValue(): string
    {
        return $this->value;
    }
}
