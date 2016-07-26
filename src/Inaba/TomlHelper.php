<?php

namespace Inaba;

use Exception;

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
}
