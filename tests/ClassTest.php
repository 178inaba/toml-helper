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
     * @group 7.0
     */
    public function testAssignmentUseMem()
    {
        $helper = TomlHelper::getInstance();
        $helper->useMem = false;
    }

    /**
     * @expectedException Error
     * @group 7.0
     */
    public function testAssignmentHost()
    {
        $helper = TomlHelper::getInstance();
        $helper->host = 'test';
    }

    /**
     * @expectedException Error
     * @group 7.0
     */
    public function testAssignmentPort()
    {
        $helper = TomlHelper::getInstance();
        $helper->port = 1234;
    }

    /**
     * @expectedException Error
     * @group 7.0
     */
    public function testAssignmentTomlDir()
    {
        $helper = TomlHelper::getInstance();
        $helper->tomlDir = 'test/dir';
    }

    /**
     * @group standard
     */
    public function testGetterSetter()
    {
        $useMem = false;
        $host = 'test';
        $port = 1234;
        $tomlDir = 'test/dir';

        $helper = TomlHelper::getInstance();
        $helper->setUseMem($useMem)
            ->setHost($host)
            ->setPort($port)
            ->setTomlDir($tomlDir);

        $this->assertSame($useMem, $helper->getUseMem());
        $this->assertSame($host, $helper->getHost());
        $this->assertSame($port, $helper->getPort());
        $this->assertSame($tomlDir, $helper->getTomlDir());

        $helper2 = TomlHelper::getInstance();

        $this->assertSame($useMem, $helper2->getUseMem());
        $this->assertSame($host, $helper2->getHost());
        $this->assertSame($port, $helper2->getPort());
        $this->assertSame($tomlDir, $helper2->getTomlDir());
    }

    /**
     * @group none
     */
    public function testGetMemcacheDNone()
    {
        $this->assertSame(null, $this->execPrivateMethod('getMemcacheD'));
    }

    /**
     * @group memcache
     */
    public function testGetMemcacheDMemcache()
    {
        $this->assertInstanceOf(Memcache::class, $this->execPrivateMethod('getMemcacheD'));
    }

    /**
     * @group hhvm
     * @group memcached
     */
    public function testGetMemcacheDMemcached()
    {
        $this->assertInstanceOf(Memcached::class, $this->execPrivateMethod('getMemcacheD'));
    }

    /**
     * @group standard
     */
    public function testParseToml()
    {
        $toml = $this->execPrivateMethod('parseToml', glob(__DIR__.'/toml/*.toml'));
        $this->assertSame('value', $toml['test']['hash']['key']);
    }

    private function execPrivateMethod($name, ...$args)
    {
        $helper = TomlHelper::getInstance();
        $class = new ReflectionClass($helper);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        $ret = null;
        if (empty($args)) {
            $ret = $method->invoke($helper);
        } else {
            $ret = $method->invokeArgs($helper, $args);
        }

        return $ret;
    }
}
