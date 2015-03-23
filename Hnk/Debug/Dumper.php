<?php

namespace Hnk\Debug;


/**
 * Class Dumper
 *
 * @author pgdba
 * @package Hnk\Debug
 */
class Dumper
{
    /**
     * @var string
     */
    protected $mode;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var bool
     */
    protected $isOptionsBuilded = false;

    /**
     * Options can hold temporary (for one dump) options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Instance options are set for single Dumper instance
     *
     * @var array
     */
    protected $instanceOptions = [];

    /**
     * Default options, this array contains all available Dumper options
     *
     * @var array
     */
    protected $defaultOptions = [
        'showBacktrace' => false,
        'outputFormat'  => null,
        'outputMethod'  => null,
    ];

    public function __construct()
    {

    }

    /**
     * Wrapper method
     *
     * @param mixed  $variable
     * @param string $name
     */
    public function dump($variable, $name = '')
    {
        $this->beforeDump();
        /** @var string $context */
        $context = (new ContextResolver())->getContext();
        $this->doDump($variable, $name, $context);
        $this->afterDump();
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @param  bool   $setAsInstance
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setOption($key, $value, $setAsInstance = false)
    {
        if (!array_key_exists($key, $this->defaultOptions)) {
            throw new \Exception(sprintf('Invalid option %s', $key));
        }

        if (true === $setAsInstance) {
            $this->instanceOptions[$key] = $value;
        } else {
            $this->options[$key] = $value;
        }

        $this->isOptionsBuilded = false;

        return $this;
    }

    /**
     * @param  string $key
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getOption($key)
    {
        if (!array_key_exists($key, $this->defaultOptions)) {
            throw new \Exception(sprintf('Invalid option %s', $key));
        }

        if (false === $this->isOptionsBuilded) {
            $this->buildOptions();
        }

        return $this->options[$key];
    }

    /**
     * @param mixed  $variable
     * @param string $name
     * @param string $context
     */
    protected function doDump($variable, $name, $context)
    {

    }

    protected function resolveOutputFormat($context)
    {
        if (null !== $this->getOption('outputFormat')) {
            return $this->getOption('outputFormat');
        }

//        if (null !== $this->getOption('outputMethod')) {
//            return $this->getOption('outputMethod');
//        }


    }

    /**
     * Method run before every dump
     */
    protected function beforeDump()
    {
        if (false === $this->isOptionsBuilded) {
            $this->buildOptions();
        }

    }

    /**
     * Method run after every dump
     */
    protected function afterDump()
    {
        $this->clearOptions();
    }

    /**
     * Builds options for single debug
     */
    protected function buildOptions()
    {
        $this->options = array_merge(
            $this->defaultOptions,
            $this->instanceOptions,
            $this->options
        );
        $this->isOptionsBuilded = true;
    }

    /**
     * Clears temporary options
     */
    protected function clearOptions()
    {
        $this->options = [];
        $this->isOptionsBuilded = false;
    }
}
