<?php

use Yosymfony\Toml\Toml;

if (! function_exists('toml')) {
    function toml($key = null)
    {
        $toml = [];

        $paths = glob('../application/configs/toml/*.toml');
        foreach ($paths as $path) {
            $filename = basename($path, '.toml');

            $toml[$filename] = Toml::Parse($path);
        }

        if ($key === null) {
            return $toml;
        }

        $keys = explode('.', $key);
        foreach ($keys as $value) {
            $toml = $toml[$value];
        }

        return $toml;
    }
}
