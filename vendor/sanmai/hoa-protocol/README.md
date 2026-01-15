[![Latest Stable Version](https://poser.pugx.org/sanmai/hoa-protocol/v/stable)](https://packagist.org/packages/sanmai/hoa-protocol)
[![Total Downloads](https://poser.pugx.org/sanmai/hoa-protocol/downloads)](https://packagist.org/packages/sanmai/hoa-protocol)

# Hoa\Protocol

This library provides the `hoa://` protocol, which is a way to abstract resource accesses. [Learn more](https://central.hoa-project.net/Documentation/Library/Protocol).

This particular fork aims to solve some deficiencies of the original library, while otherwise being a feature match to the original package. Specifically, this fork comes without the global `resolve()` function, which is known to cause a conflict with some versions of Laravel.

This library requires PHP 8.2+ and is routinely tested. Please report any issues.

## Installation

With [Composer](https://getcomposer.org/), to include this library into
your dependencies, you need to...

```sh
composer require sanmai/hoa-protocol
```

## Testing

Before running the test suites, the development dependencies must be installed:

```sh
composer install
```

Then, to run all the test suites:

```sh
vendor/bin/phpunit
```

Or use the composer script:

```sh
composer test
```

## Code Style

This project uses PHP CS Fixer to maintain consistent code style:

```sh
# Check code style
composer cs:check

# Fix code style automatically
composer cs:fix
```

## Static Analysis

This project uses PHPStan with custom rules for static analysis, running in an isolated environment to avoid Hoa dependency conflicts:

```sh
composer phpstan
```

**Note**: PHPStan runs in an isolated environment using `bamarni/composer-bin-plugin` to avoid conflicts between the project's required Hoa v2.x libraries and PHPStan's bundled Hoa v1.x dependencies. 

## License

Hoa is under the New BSD License (BSD-3-Clause). Please, see
[`LICENSE`](https://hoa-project.net/LICENSE) for details.
