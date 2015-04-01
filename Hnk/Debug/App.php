<?php

namespace Hnk\Debug;

use Hnk\Debug\Config\BaseConfig;
use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextFactory;
use Hnk\Debug\Format\FormatFactory;
use Hnk\Debug\Output\OutputFactory;

class App
{
    /**
     * @var BaseConfig
     */
    protected $config;

    /**
     * @var ContextFactory
     */
    protected $contextFactory;

    /**
     * @var FormatFactory
     */
    protected $formatFactory;

    /**
     * @var OutputFactory
     */
    protected $outputFactory;

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
                new ContextFactory(),
                new BaseConfig(),
                new FormatFactory(),
                new OutputFactory()
            );
        }

        return self::$instance;
    }

    /**
     * Construct is protected to allow extending this class
     *
     * @param ContextFactory $contextFactory
     * @param BaseConfig      $config
     * @param FormatFactory  $formatFactory
     * @param OutputFactory  $outputFactory
     */
    protected function __construct(
        ContextFactory $contextFactory,
        BaseConfig $config,
        FormatFactory $formatFactory,
        OutputFactory $outputFactory
    ) {
        $this->contextFactory = $contextFactory;
        $this->config = $config;
        $this->formatFactory = $formatFactory;
        $this->outputFactory = $outputFactory;
    }

    /**
     * @return BaseConfig
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return ContextFactory
     */
    public function getContextFactory()
    {
        return $this->contextFactory;
    }

    /**
     * @return FormatFactory
     */
    public function getFormatFactory()
    {
        return $this->formatFactory;
    }

    /**
     * @return OutputFactory
     */
    public function getOutputFactory()
    {
        return $this->outputFactory;
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
