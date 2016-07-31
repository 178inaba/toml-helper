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
    public function testCloneNotAllow()
    {
        $helper = TomlHelper::getInstance();
        $helper2 = clone $helper;
    }

    /**
     * @expectedException Error
     * @group standard
     */
    public function testAssignmentUseMem()
    {
        $helper = TomlHelper::getInstance();
        $helper->useMem = false;
    }

    /**
     * @expectedException Error
     * @group standard
     */
    public function testAssignmentHost()
    {
        $helper = TomlHelper::getInstance();
        $helper->host = 'test';
    }

    /**
     * @expectedException Error
     * @group standard
     */
    public function testAssignmentPort()
    {
        $helper = TomlHelper::getInstance();
        $helper->port = 1234;
    }

    /**
     * @group standard
     */
    public function testGetterSetter()
    {
        $useMem = false;
        $host = 'test';
        $port = 1234;

        $helper = TomlHelper::getInstance();
        $helper->setUseMem($useMem)
            ->setHost($host)
            ->setPort($port);

        $this->assertSame($useMem, $helper->getUseMem());
        $this->assertSame($host, $helper->getHost());
        $this->assertSame($port, $helper->getPort());
    }
}
