<?php

use PHPUnit\Framework\TestCase;

class TomloadTest extends TestCase
{
    public function testToml()
    {
        putenv('TOML_DIR='.__DIR__.'/tomls');
        $value = toml('test.test.key');

        $this->assertEquals('value', $value);
    }
}
