<?php

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;

/**
 * @author pgdba
 */
interface FormatInterface
{
    /**
     * Returns format name
     * 
     * @return string
     */
    public function getName();
    
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
    public function getFormattedVariable($variable, $name, ConfigInterface $config, $backtrace);
}
