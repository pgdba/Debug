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
    protected $options = [];
    
    /**
     * Default options, this array contains all available Dumper options
     * 
     * @var array 
     */
    protected $defaultOptions = [
        'showBacktrace' => false,
        'outputFormat'  => null,
        'outputMethod'  => null,
        'debugFile'     => null,
        'maxDepth'      => 5,
    ];

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
