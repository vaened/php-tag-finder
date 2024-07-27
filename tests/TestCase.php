<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\TagFinder\Tests;

use PHPUnit\Framework\TestCase as PhpUnitTestCase;

use function array_filter;
use function implode;
use function preg_replace;

abstract class TestCase extends PhpUnitTestCase
{
    protected static function basePath(string $path = null): string
    {
        $paths = array_filter([
            __DIR__,
            $path == null ? null : preg_replace('/^\\/|\\/$/', '', $path)
        ]);

        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}