<?php

namespace Hnk\Debug;

use Hnk\Debug\Config\BaseConfig;
use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextResolver;
use Hnk\Debug\Format\FormatResolver;
use Hnk\Debug\Output\OutputResolver;

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

    /**
     * @var FormatResolver
     */
    protected $formatResolver;

    /**
     * @var OutputResolver
     */
    protected $outputResolver;

    /**
     * @var App
     */
    private static $instance = null;

    /**
     * @return App
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new App(
                new ContextResolver(),
                new BaseConfig(),
                new FormatResolver(),
                new OutputResolver()
            );
        }

        return self::$instance;
    }

    /**
     * Construct is protected to allow extending this class
     *
     * @param ContextResolver $contextResolver
     * @param BaseConfig      $config
     * @param FormatResolver  $formatResolver
     * @param OutputResolver  $outputResolver
     */
    protected function __construct(
        ContextResolver $contextResolver,
        BaseConfig $config,
        FormatResolver $formatResolver,
        OutputResolver $outputResolver
    ) {
        $this->contextResolver = $contextResolver;
        $this->config = $config;
        $this->formatResolver = $formatResolver;
        $this->outputResolver = $outputResolver;
    }

    /**
     * @return BaseConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return ContextResolver
     */
    public function getContextResolver()
    {
        return $this->contextResolver;
    }

    /**
     * @return FormatResolver
     */
    public function getFormatResolver()
    {
        return $this->formatResolver;
    }

    /**
     * @return OutputResolver
     */
    public function getOutputResolver()
    {
        return $this->outputResolver;
    }

    /**
     * @param  array|string $helper
     *
     * @throws \Exception
     */
    public function registerHelpers($helper)
    {
         if (!is_array($helper)) {
            if (!is_string($helper)) {
                throw new \Exception('Helpers should be registered as strings');
            }
            $helper = array($helper);
        }

        $this->config->addOption(ConfigInterface::OPTION_HELPERS, $helper);
    }
}
