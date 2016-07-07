<?php

use PHPUnit\Framework\TestCase;

class TomloadTest extends TestCase
{
    protected function setUp()
    {
        putenv('TOML_DIR='.__DIR__.'/tomls');
    }

    public function testGetValue()
    {
        $value = toml('test.hash.key');
        $this->assertEquals('value', $value);
    }

    public function testNotExistKeyIsNull()
    {
        $value = toml('test.not_exist');
        $this->assertNull($value);
    }
}
