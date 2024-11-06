<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\TagFinder;

use SplFileInfo;
use Symfony\Component\Finder\Finder;
use Vaened\Support\Types\ArrayList;

use function class_exists;
use function explode;
use function file_exists;
use function is_subclass_of;
use function Lambdish\Phunctional\reduce;
use function str_replace;
use function trim;

final class ClassFinder
{
    public function __construct(
        private readonly string $source,
        private readonly string $namespace,
    )
    {
    }

    public function instancesOf(string $abstract): array
    {
        return $this->repository()
                    ->each($this->load())
                    ->filter($this->exists())
                    ->filter($this->instanceOf($abstract))
                    ->items();
    }

    private function repository(): ArrayList
    {
        return new ArrayList(
            reduce(
                self::normalize(),
                Finder::create()
                      ->in($this->source)
                      ->name('*.php'),
                new ArrayList([])
            )
        );
    }

    private function load(): callable
    {
        return static function (string $class, string $PHPFile): void {
            if (file_exists($PHPFile)) {
                require_once $PHPFile;
            }
        };
    }

    private function exists(): callable
    {
        return static fn(string $className) => class_exists($className, false);
    }

    private function instanceOf(string $interface): callable
    {
        return static fn(string $className) => is_subclass_of($className, $interface);
    }

    private function normalize(): callable
    {
        return function (ArrayList $classes, SplFileInfo $info) {
            $file = $info->getRealPath();
            $classes->push($this->extract($file), $file);
            return $classes;
        };
    }

    private function extract(string $file): string
    {
        $file   = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $file);
        $source = trim($this->source, DIRECTORY_SEPARATOR);
        [, $namespaced] = explode($source . DIRECTORY_SEPARATOR, $file);
        $class = str_replace([DIRECTORY_SEPARATOR, '.php'], ['\\', ''], $namespaced);

        return "$this->namespace\\$class";
    }
}
