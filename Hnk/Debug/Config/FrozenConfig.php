<?php


namespace Hnk\Debug\Config;

/**
 * Description of FrozenConfig
 *
 * @author pgdba
 */
class FrozenConfig implements ConfigInterface
{
    /**
     * @var array
     */
    protected $options = [];
    
    /**
     * @param array $options
     */
    public function __construct($options)
    {
        $this->options = $options;
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
}
