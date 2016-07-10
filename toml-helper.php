<?php

use Yosymfony\Toml\Toml;

if (! function_exists('toml')) {
    function toml($keyChain = null)
    {
        $toml = [];

        $m = null;
        $mId = '178inaba/toml_helper:toml';
        $host = _get_mem_host();
        $port = _get_mem_port();
        if (extension_loaded('memcached')) {
            $m = new Memcached($mId);
            if (empty($m->getServerList())) {
                $m->addServer($host, $port);
            }
        } elseif (extension_loaded('memcache')) {
            $m = new Memcache();
            $m->addServer($host, $port);
        }

        if ($m === null) {
            $toml = _parse_toml();
        } else {
            $toml = @$m->get($mId);
            if ($toml === false) {
                $toml = _parse_toml();
                $m->set($mId, $toml);
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

    function _parse_toml()
    {
        $toml = [];

        // get directory
        $tomlDir = getenv('TOML_DIR');
        if ($tomlDir === false) {
            // default
            $tomlDir = '../tomls';
        }

        $paths = glob($tomlDir.'/*.toml');
        foreach ($paths as $path) {
            $toml[basename($path, '.toml')] = Toml::Parse($path);
        }

        return $toml;
    }

    function _get_mem_host()
    {
        $host = getenv('MEM_HOST');
        if ($host === false) {
            // default
            $host = 'localhost';
        }

        return $host;
    }

    function _get_mem_port()
    {
        $port = getenv('MEM_PORT');
        if ($port === false) {
            // default
            $port = 11211;
        }

        return $port;
    }
}
