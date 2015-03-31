<?php

namespace Hnk\Debug\Config;

/**
 *
 * @author pgdba
 */
class BaseConfig implements ConfigInterface
{
    /**
     * @var array
     */
    protected $options = array();
    
    /**
     * Default options, this array contains all available Dumper options
     * 
     * @var array 
     */
    protected $defaultOptions = array(
        'showBacktrace' => false,
        'outputFormat'  => null,
        'outputMethod'  => null,
        'debugFile'     => null,
        'maxDepth'      => 5,
    );
    
    /**
     * @var BaseConfig 
     */
    private static $instance = null;
    
    /**
     * @return BaseConfig
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new BaseConfig();
        }
        
        return self::$instance;
    }
    
    /**
     * 
     * @param  string $key
     * @param  mixed  $value
     * 
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
        
        return $this;
    }
    
    /**
     * @param  string $key
     * @param  mixed  $default
     * 
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return (array_key_exists($key, $this->options)) ? $this->options[$key] : $default;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return array_merge($this->defaultOptions, $this->options);
    }
}
