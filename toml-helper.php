<?php

use Yosymfony\Toml\Toml;

if (! function_exists('toml')) {
    function toml($keyChain = null)
    {
        $toml = [];

        $m = null;
        $mId = '178inaba/toml_helper:toml';
        if (extension_loaded('memcache')) {
            $m = new Memcache();
            $m->addServer('localhost', 11211);
        } elseif (extension_loaded('memcached')) {
            $m = new Memcached($mId);
            if (empty($m->getServerList())) {
                $m->addServer('localhost', 11211);
            }
        }

        if ($m === null) {
            $toml = _parse_toml();
        } else {
            $toml = $m->get($mId);
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
}
