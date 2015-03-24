<?php

namespace Hnk\Debug;

use Hnk\Debug\Config\BaseConfig;
use Hnk\Debug\Context\ContextResolver;

class App
{
    /**
     * @var BaseConfig
     */
    protected $config;

    /**
     * @var ContextResolver
     */
    protected $contextResolver;

//    protected

    /**
     * @var App
     */
    private static $instance = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new App(
                new ContextResolver()
            );
        }

        return self::$instance;
    }

    /**
     * Construct is protected to allow extending this class
     */
    protected function __construct(ContextResolver $contextResolver)
    {

    }

    public function getConfig()
    {

    }

}
