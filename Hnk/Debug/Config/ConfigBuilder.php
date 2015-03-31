<?php

namespace Hnk\Debug\Config;

/**
 * Description of ConfigBuilder
 *
 * @author pgdba
 */
class ConfigBuilder
{
    /**
     * @var BaseConfig
     */
    protected $config;
    
    /**
     * @param BaseConfig $config
     */
    public function __construct(BaseConfig $config)
    {
        $this->config = $config;
    }
    
    /**
     * @param  array $options
     * 
     * @return ConfigInterface
     */
    public function buildConfig($options)
    {
        if (!is_array($options)) {
            $options = array();
        }
        
        $defaultOptions = $this->config->getOptions();
        
        $mergedOptions = array_merge($defaultOptions, $options);
        
        return new FrozenConfig($mergedOptions);
    }
}
