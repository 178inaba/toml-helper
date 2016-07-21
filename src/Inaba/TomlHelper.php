<?php

namespace Inaba;

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
     *
     * @return void
     */
    private function __construct()
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
}
