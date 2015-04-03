<?php

namespace Hnk\Debug;

use Hnk\Debug\Config\BaseConfig;
use Hnk\Debug\Config\ConfigBuilder;
use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextInterface;
use Hnk\Debug\Context\ContextFactory;
use Hnk\Debug\Format\FormatAbstract;
use Hnk\Debug\Format\FormatFactory;
use Hnk\Debug\Output\OutputInterface;
use Hnk\Debug\Output\OutputFactory;

/**
 * Class Dumper
 *
 * @author pgdba
 * @package Hnk\Debug
 */
class Dumper
{
    /**
     * Options can hold temporary (for one dump) options
     *
     * @var array
     */
    protected $options = [];

    /**
     * @var ConfigInterface 
     */
    protected $config;

    /**
     * @var App
     */
    protected $app;
    
    public function __construct()
    {
        $this->app = App::getInstance();
    }
    
    /**
     * Wrapper method
     *
     * @param  mixed  $variable
     * @param  string $name
     *
     * @return mixed
     */
    public function dump($variable, $name = '')
    {
        if (ConfigInterface::MODE_OFF === $this->getMode()) {
            return;
        }

        $this->beforeDump();
        
        $context = $this->getContext();
        $output = $this->getOutput();
        $format = $this->getFormat($context, $output);

        $var = $this->exportVariable($variable);

        $backtrace = $this->getBacktrace();
        
        $debug = $format->getFormattedVariable($var, $name, $this->config, $backtrace);
        
        $return = $output->output($debug, $this->config);

        $this->afterDump();

        return $return;
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @param  bool   $allowReplace
     *
     * @return $this
     */
    public function setOption($key, $value, $allowReplace = true)
    {
        if (true === $allowReplace || false === array_key_exists($key, $this->options)) {
            $this->options[$key] = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->app->getConfig()->getOption(ConfigInterface::OPTION_MODE);
    }

    /**
     * @return ContextInterface
     */
    protected function getContext()
    {
        return $this->app->getContextFactory()->getContext();
    }

    /**
     * @return OutputInterface
     */
    protected function getOutput()
    {
        return $this->app->getOutputFactory()->getOutput($this->config);
    }

    /**
     * @param  ContextInterface $context
     * @param  OutputInterface  $output
     *
     * @return FormatAbstract
     */
    protected function getFormat(ContextInterface $context, OutputInterface $output)
    {
        return $this->app->getFormatFactory()->getFormat($this->config, $context, $output);
    }

    /**
     * @param  mixed $variable
     *
     * @return mixed
     */
    protected function exportVariable($variable)
    {
        $maxDepth = $this->config->getOption(ConfigInterface::OPTION_MAX_DEPTH);

        return VariableExporter::export($variable, $maxDepth);
    }

    protected function getBacktrace()
    {
        $return = [
            'invoke' => [
                'file' => null,
                'line' => null,
            ],
            'trace' => []
        ];

        $backtrace = debug_backtrace();
        $backtraceCount = count($backtrace);
        $i = 0;
        $addToTrace = false;

        $helpers = $this->config->getOption('helpers', []);
        $helpers[] = sprintf('%s::%s', __CLASS__, 'dump');
        
        while ($i <= $backtraceCount - 1) {

            $class      = (isset($backtrace[$i]['class'])) ? $backtrace[$i]['class'] : '';
            $function   = (isset($backtrace[$i]['function'])) ? $backtrace[$i]['function'] : '';
            $file       = (isset($backtrace[$i]['file'])) ? $backtrace[$i]['file'] : '';
            $line       = (isset($backtrace[$i]['line'])) ? $backtrace[$i]['line'] : '';
            
            $callable = sprintf(
                '%s%s',
                ($class) ? $class.'::' : '',
                $function
            );
            
            if (in_array($callable, $helpers)) {
                $addToTrace = true;
                $return['trace'] = [];
                $return['invoke']['file'] = $file;
                $return['invoke']['line'] = $line;
            }

            if (true === $addToTrace) {
                $return['trace'][] = [
                    'callable' => $callable,
                    'class' => $class,
                    'function' => $function,
                    'file' => $file,
                    'line' => $line,
                ];
            }
            
            $i++;
        }
        
        return $return;
    }
    
    /**
     * Method run before every dump
     */
    protected function beforeDump()
    {
        $this->buildOptions();
    }

    /**
     * Method run after every dump
     */
    protected function afterDump()
    {
    }

    /**
     * Builds options for single debug
     */
    protected function buildOptions()
    {
        $configBuilder = new ConfigBuilder($this->app->getConfig());
        
        $this->setOption('mode', $this->mode);
        
        $this->config = $configBuilder->buildConfig($this->options);
    }

}
