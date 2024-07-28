<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\TagFinder\Tests;

use PHPUnit\Framework\Attributes\Test;
use Vaened\TagFinder\ClassFinder;
use Vaened\TagFinder\Tests\App\Handler;

final class ClassFinderTest extends TestCase
{
    #[Test]
    public function find_tagged_classes_as_entities(): void
    {
        $basePath = self::basePath('App');
        $finder   = new ClassFinder($basePath, 'Vaened\\TagFinder\\Tests\\App');
        $classes  = $finder->instancesOf(Handler::class);

        $this->assertCount(2, $classes);
        $this->assertSame([
            "$basePath/Products/CreateProductHandler.php"    => "Vaened\TagFinder\Tests\App\Products\CreateProductHandler",
            "$basePath/Categories/CreateCategoryHandler.php" => "Vaened\TagFinder\Tests\App\Categories\CreateCategoryHandler",
        ], $classes);
    }
}