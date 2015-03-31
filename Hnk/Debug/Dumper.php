<?php

namespace Hnk\Debug;

use Hnk\Debug\Config\BaseConfig;
use Hnk\Debug\Config\ConfigBuilder;
use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextInterface;
use Hnk\Debug\Context\ContextResolver;
use Hnk\Debug\Format\FormatInterface;
use Hnk\Debug\Format\FormatResolver;
use Hnk\Debug\Output\OutputInterface;
use Hnk\Debug\Output\OutputResolver;

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
     * Options can hold temporary (for one dump) options
     *
     * @var array
     */
    protected $options = array();

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
     * @param mixed  $variable
     * @param string $name
     */
    public function dump($variable, $name = '')
    {
        $this->beforeDump();
        
        $contextResolver = new ContextResolver();
        
        /** @var ContextInterface $context */
        $context = $contextResolver->getContext();
        
        $outputResolver = new OutputResolver();
        /** @var OutputInterface $output */
        $output = $outputResolver->getOutput($this->config);
        
        $formatResolver = new FormatResolver();
        /** @var FormatInterface $format */
        $format = $formatResolver->getFormat($this->config, $context, $output);
        
        $maxDepth = $this->config->getOption('maxDepth');
        
        $var = VariableExporter::export($variable, $maxDepth);
        $backtrace = $this->getBacktrace();
        
        $debug = $format->getFormattedVariable($var, $name, $this->config, $backtrace);
        
        $output->output($debug, $this->config);

        $this->afterDump();
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
     * @param  string $mode
     * 
     * @return $this
     */
    public function setMode($mode) 
    {
        $this->mode = $mode;
        
        return $this;
    }
    
    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    protected function getBacktrace()
    {
        $return = array(
            'invoke' => array(
                'file' => null,
                'line' => null,
            ),
            'trace' => array()
        );

        $backtrace = debug_backtrace();
        $backtraceCount = count($backtrace);
        $i = $backtraceCount - 1;
        $addToTrace = false;
        $helpers = $this->config->getOption('helpers', array());
        $helpers[] = sprintf('%s::%s', __CLASS__, 'dump');
        
        while ($i > 0) {
            $class = (isset($backtrace[$i]['class'])) ? $backtrace[$i]['class'] : '';
            $function = (isset($backtrace[$i]['function'])) ? $backtrace[$i]['function'] : '';
            $file = (isset($backtrace[$i]['file'])) ? $backtrace[$i]['file'] : '';
            $line = (isset($backtrace[$i]['line'])) ? $backtrace[$i]['line'] : '';
            
            $callable = sprintf(
                '%s%s',
                ($class) ? $class.'::' : '',
                $function
            );
            
            if (false == $addToTrace && in_array($callable, $helpers)) {
                $addToTrace = true;
                $return['invoke']['file'] = $file;
                $return['invoke']['line'] = $line;
            }
            
            if (true === $addToTrace) {
                $return['trace'][] = array(
                    'class' => $class,
                    'function' => $function,
                    'file' => $file,
                    'line' => $line,
                );
            }
            
            $i--;
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
        $configBuilder = new ConfigBuilder(BaseConfig::getInstance());
        
        $this->setOption('mode', $this->mode);
        
        $this->config = $configBuilder->buildConfig($this->options);
    }

}
