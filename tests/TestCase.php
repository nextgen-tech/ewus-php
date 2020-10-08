<?php
declare(strict_types=1);

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function xmlRequest(string $name): string
    {
        $content = file_get_contents(__DIR__ . '/XML/' . $name);

        if ($content === false || empty($content)) {
            throw new InvalidArgumentException('');
        }

        return $content;
    }
}
