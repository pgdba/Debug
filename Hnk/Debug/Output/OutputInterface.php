<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;

/**
 *
 * @author pgdba
 */
interface OutputInterface
{
    /**
     * Returns context name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Returns default format name
     * 
     * @return string
     */
    public function getDefaultFormatName();
    
    /**
     * @param string          $debug
     * @param ConfigInterface $config
     */
    public function output($debug, ConfigInterface $config);
}
