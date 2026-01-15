<?php

declare(strict_types=1);

// Stubs for missing dependencies in isolated PHPStan environment

namespace Hoa {
    class Exception extends \Exception
    {
        public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }
}

namespace Hoa\Protocol {
    class Protocol
    {
        public static function getInstance(): self
        {
            return new self();
        }
    }
}

namespace Hoa {
    class Protocol
    {
        public static function getInstance(): \Hoa\Protocol\Protocol
        {
            return new \Hoa\Protocol\Protocol();
        }
    }
}

namespace {
    class_alias('Hoa\Protocol\Protocol', 'Hoa\Protocol');
}

namespace Hoa\Console\Dispatcher {
    class Kit
    {
        /** @var array<string, mixed> */
        protected array $options = [];
        protected mixed $parser = null;

        public function getOption(mixed &$v): bool
        {
            return false;
        }
        public function usage(): int
        {
            return 0;
        }
        /** @param array<string, mixed> $options */
        public function makeUsageOptionsList(array $options): string
        {
            return '';
        }
        public function resolveOptionAmbiguity(string &$v): void
        {
        }
    }
}

namespace Hoa\Console {
    class GetOption
    {
        public const NO_ARGUMENT = 0;
    }

    class Console
    {
        public static function isDirect(mixed $stream): bool
        {
            return true;
        }
    }

    class Cursor
    {
        public static function colorize(string $color): string
        {
            return '';
        }
    }
}

namespace PHPUnit\Framework {
    class TestCase
    {
        public function assertInstanceOf(string $expected, mixed $actual, string $message = ''): void
        {
        }
        public function assertIsString(mixed $actual, string $message = ''): void
        {
        }
        public function assertSame(mixed $expected, mixed $actual, string $message = ''): void
        {
        }
        public function assertIsArray(mixed $actual, string $message = ''): void
        {
        }
        public function assertNotEmpty(mixed $actual, string $message = ''): void
        {
        }
        public function assertStringContainsString(string $needle, string $haystack, string $message = ''): void
        {
        }
        public function assertNull(mixed $actual, string $message = ''): void
        {
        }
        public function assertIsBool(mixed $actual, string $message = ''): void
        {
        }
        public function assertFalse(mixed $actual, string $message = ''): void
        {
        }
        public function assertTrue(mixed $actual, string $message = ''): void
        {
        }
        /** @param array<mixed, mixed> $array */
        public function assertArrayHasKey(int|string $key, array $array, string $message = ''): void
        {
        }
        /** @param iterable<mixed> $haystack */
        public function assertContains(mixed $needle, iterable $haystack, string $message = ''): void
        {
        }
    }
}
