<?php

use Inaba\TomlHelper;

if (! function_exists('toml')) {
    function toml($keyChain = null)
    {
        $helper = TomlHelper::getInstance();

        if (getenv('TOML_NOT_USE_MEM')) {
            $helper->setUseMem(false);
        }

        $tomlMemHost = getenv('TOML_MEM_HOST');
        if ($tomlMemHost !== false) {
            $helper->setHost($tomlMemHost);
        }

        $tomlMemPort = getenv('TOML_MEM_PORT');
        if ($tomlMemPort !== false) {
            $helper->setPort($tomlMemPort);
        }

        $tomlDir = getenv('TOML_DIR');
        if ($tomlDir !== false) {
            $helper->setTomlDir($tomlDir);
        }

        return $helper->get($keyChain);
    }
}
