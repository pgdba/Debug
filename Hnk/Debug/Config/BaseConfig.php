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
        self::OPTION_MODE           => self::MODE_OFF,
        self::OPTION_HELPERS        => array(),
        self::OPTION_SHOW_BACKTRACE => false,
        self::OPTION_OUTPUT_FORMAT  => null,
        self::OPTION_OUTPUT_METHOD  => null,
        self::OPTION_DEBUG_FILE     => null,
        self::OPTION_MAX_DEPTH      => 5,
        self::OPTION_VERBOSE        => false,
    );

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
     * @param  mixed  $additionalValue
     *
     * @throws \Exception
     */
    public function addOption($key, $additionalValue)
    {
        $optionType = $this->getOptionType($key);
        if ('array' !== $optionType) {
            throw new \Exception(sprintf('Option %s is of type %s'));
        }

        $currentValue = $this->getOption($key, array());
        if (!is_array($additionalValue)) {
            $additionalValue = array($additionalValue);
        }

        $this->setOption($key, array_merge($currentValue, $additionalValue));
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

    /**
     * @param  string $key
     *
     * @return bool
     */
    public function optionExists($key)
    {
        return array_key_exists($key, $this->defaultOptions);
    }

    /**
     * @param  string $key
     *
     * @return string
     *
     * @throws \Exception
     */
    public function getOptionType($key)
    {
        if (!$this->optionExists($key)) {
            throw new \Exception(sprintf('Option %s does not exist', $key));
        }

        $type = gettype($this->defaultOptions[$key]);

        if ('NULL' === $type) {
            $type = 'string'; // @TODO - change this
        }

        return $type;
    }
}
