<?php

declare(strict_types=1);

namespace LuminescentGem\SaqsTest;

use PHPUnit\Framework\TestCase;

class PhpVersionTest extends TestCase
{
    private const MINIMUM_PHP_VERSION = '8.0.0';

    public function testPhpVersion(): void
    {
        self::assertGreaterThanOrEqual(
            0,
            version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION),
            sprintf('PHP version %s must be at least %s', PHP_VERSION, self::MINIMUM_PHP_VERSION)
        );
    }
}
