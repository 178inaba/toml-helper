<?php

namespace Inaba;

use Exception;
use Yosymfony\Toml\Toml;

class TomlHelper
{
    /**
     * Helper instance.
     *
     * @var static
     */
    private static $instance;

    /**
     * Constructor.
     * Keep in private so as not new let from outside.
     * Can not override.
     *
     * @return void
     */
    final private function __construct()
    {
    }

    /**
     * Set instance of helper.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * Clone does not allow.
     * Can not override.
     *
     * @return void
     */
    final public function __clone()
    {
        throw new Exception('Clone is not allowed against '.__CLASS__.'.');
    }

    // TODO

    public function toml($keyChain = null)
    {
        $toml = [];

        $m = null;
        if (! getenv('TOML_NOT_USE_MEM')) {
            $m = _get_memcache_d();
        }

        $paths = _get_paths();
        if ($m === null) {
            $toml = _parse_toml($paths);
        } else {
            $maxUpdateTime = 0;
            foreach ($paths as $path) {
                $updateTime = filemtime($path);
                if ($maxUpdateTime < $updateTime) {
                    $maxUpdateTime = $updateTime;
                }
            }

            $mBaseKey = '178inaba/toml_helper:';
            $mTimeKey = __DIR__.':time';
            $mTomlKey = __DIR__.':toml';

            $memUpdateTime = @$m->get($mBaseKey.$mTimeKey);
            if ($memUpdateTime < $maxUpdateTime) {
                $toml = _parse_toml($paths);
                $m->set($mBaseKey.$mTomlKey, $toml);
                $m->set($mBaseKey.$mTimeKey, $maxUpdateTime);
            } else {
                $toml = @$m->get($mBaseKey.$mTomlKey);
                if ($toml === false) {
                    $toml = _parse_toml($paths);
                    $m->set($mBaseKey.$mTomlKey, $toml);
                }
            }
        }

        if ($keyChain === null) {
            return $toml;
        }

        $keys = explode('.', $keyChain);
        foreach ($keys as $key) {
            $toml = @$toml[$key];
        }

        return $toml;
    }

    private function parse_toml(array $paths)
    {
        $toml = [];

        foreach ($paths as $path) {
            $toml[basename($path, '.toml')] = Toml::Parse($path);
        }

        return $toml;
    }

    private function get_mem_host()
    {
        $host = getenv('MEM_HOST');
        if ($host === false) {
            // default
            $host = 'localhost';
        }

        return $host;
    }

    private function get_mem_port()
    {
        $port = getenv('MEM_PORT');
        if ($port === false) {
            // default
            $port = 11211;
        }

        return $port;
    }

    private function get_memcache_d()
    {
        $m = null;
        $host = _get_mem_host();
        $port = _get_mem_port();
        if (extension_loaded('memcached')) {
            $m = new Memcached('178inaba/toml_helper');
            if (empty($m->getServerList())) {
                $m->addServer($host, $port);
            }
        } elseif (extension_loaded('memcache')) {
            $m = new Memcache();
            $m->addServer($host, $port);
        }

        return $m;
    }

    private function get_paths()
    {
        // get directory
        $tomlDir = getenv('TOML_DIR');
        if ($tomlDir === false) {
            // default
            $tomlDir = '../tomls';
        }

        return glob($tomlDir.'/*.toml');
    }
}
