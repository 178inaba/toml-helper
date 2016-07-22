<?php

use PHPUnit\Framework\TestCase;
use Inaba\TomlHelper;

class ClassTest extends TestCase
{
    /**
     * @expectedException Error
     * @group 7.0
     */
    public function testNewToError()
    {
        new TomlHelper;
    }

    /**
     * @group standard
     */
    public function testGetInstance()
    {
        // check class type
        $helper = TomlHelper::getInstance();
        $this->assertInstanceOf(TomlHelper::class, $helper);

        // check same instance
        $helper2 = TomlHelper::getInstance();
        $this->assertSame($helper, $helper2);
    }

    /**
     * @expectedException Error
     * @group 7.0
     */
    public function testOverwriteInstance()
    {
        $helper = TomlHelper::getInstance();
        $helper->instance = true;
    }

    /**
     * @expectedException Exception
     * @group standard
     */
    public function testClone()
    {
        $helper = TomlHelper::getInstance();
        $helper2 = clone $helper;
    }
}
