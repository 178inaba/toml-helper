<?php

use Yosymfony\Toml\Toml;

if (! function_exists('toml')) {
    function toml($keyChain = null)
    {
        $toml = [];

        $paths = glob('../application/configs/toml/*.toml');
        foreach ($paths as $path) {
            $filename = basename($path, '.toml');

            $toml[$filename] = Toml::Parse($path);
        }

        if ($keyChain === null) {
            return $toml;
        }

        $keys = explode('.', $keyChain);
        foreach ($keys as $key) {
            $toml = $toml[$key];
        }

        return $toml;
    }
}
