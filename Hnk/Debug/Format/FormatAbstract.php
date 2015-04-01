<?php

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;

/**
 * @author pgdba
 */
abstract class FormatAbstract
{
    /**
     * Returns format name
     * 
     * @return string
     */
    abstract public function getName();
    
    /**
     * Returns formatted variable
     * 
     * @param  mixed           $variable
     * @param  string          $name
     * @param  ConfigInterface $config
     * @param  array           $backtrace
     * 
     * @return string
     */
    abstract public function getFormattedVariable($variable, $name, ConfigInterface $config, $backtrace);

    /**
     * @param mixed           $var
     * @param ConfigInterface $config
     *
     * @return string
     */
    protected function dumpVariable($var, ConfigInterface $config)
    {
        $verbose = $config->getOption(ConfigInterface::OPTION_VERBOSE, false);

        if (!is_array($var) && !is_object($var)) {
            $verbose = true;
        }

        if (true === $verbose) {
            return var_export($var, true);
        } else {
            return print_r($var, true);
        }
    }
}
