<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\TagFinder\Tests;

use PHPUnit\Framework\Attributes\Test;
use Vaened\TagFinder\ClassFinder;
use Vaened\TagFinder\Tests\App\Entity;

final class ClassFinderTest extends TestCase
{
    #[Test]
    public function find_tagged_classes_as_entities(): void
    {
        $finder  = new ClassFinder(self::basePath('App'), 'Vaened\\TagFinder\\Tests\\App');
        $classes = $finder->instancesOf(Entity::class);
        
        $this->assertCount(2, $classes);
        $this->assertSame([
            "/app/tests/App/Products/Product.php"    => "Vaened\TagFinder\Tests\App\Products\Product",
            "/app/tests/App/Categories/Category.php" => "Vaened\TagFinder\Tests\App\Categories\Category",
        ], $classes);
    }
}