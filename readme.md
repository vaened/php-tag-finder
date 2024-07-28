# Tag Finder

Library created to simplify the search for PHP classes based on their parent class/interface.

## Installation

You can install the library using `composer`.

```shell 
composer require vaened/php-tag-finder
```

## Usage

The definition of `tag` in this library is understood as an `interface` or `abstract class`.

With that in mind, to obtain, for example, all the `handlers` of a system, it would be enough to search for all the PHP classes that
implement the `Handler` interface.

```php
$finder  = new ClassFinder(...);
$classes = $finder->instancesOf(Handler::class);
```

This will return an associative array, where the key is the physical location of the file on disk and the value is the class it references
in the project.

## Configuration

The configuration consists of how to create the `ClassFinder`, for this we must understand 2 concepts, the `source` where the search will be
performed, and the `namespace` that represents that location.

- **source**: the location where you will start looking for tagged classes.
- **namespace**: the representation of this location in the project.

### Example

Let's suppose that the project is called Ecommerce, where the namespace is also `Ecommerce\\`.

```md
─── src
    ├── App
    │ ├── Categories
    │ │ └── CreateCategoryHandler.php
    │ ├─── Products
    │ │ └── CreateProductHandler.php
    │ ├── Handler.php
```

So, to locate only the classes that correspond to the application, in this case you would have to instantiate the ClassFinder to search
within the root of the project/App, with its equivalent for the namespace.

```php
$paths  = [$rootProyectPath, 'src', 'App'];
$finder = new ClassFinder(
    implode(DIRECTORY_SEPARATOR, $paths),
    'Ecommerce\\App'
);
```

## License

This library is licensed under the MIT License. For more information, please see the [`license`](./license) file.