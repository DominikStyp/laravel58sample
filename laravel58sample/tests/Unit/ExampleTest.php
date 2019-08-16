<?php

declare(strict_types=1);
namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

    public function add(int $a, int $b): int
    {
        return $a + $b;
    }
    /**
     * @dataProvider additionProvider
     */
    public function testAdd(int $a, int $b, int $expected)
    {
        $this->assertSame($expected, $this->add($a, $b));
    }

    public function additionProvider()
    {
        return [
            [1, 1, 2],
            [3, 4, 7],
            [3, -1, 2],
            [-2, 2, 0]
        ];
    }
}
