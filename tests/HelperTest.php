<?php

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    protected function setUp()
    {
        putenv('TOML_DIR='.__DIR__.'/tomls');
    }

    /**
     * @group standard
     */
    public function testGetValue()
    {
        $value = toml('test.hash.key');
        $this->assertEquals('value', $value);
    }

    /**
     * @group standard
     */
    public function testNotExistKeyIsNull()
    {
        $value = toml('test.not_exist');
        $this->assertNull($value);
    }
}
