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
     * @param  string          $debug
     * @param  ConfigInterface $config
     *
     * @return mixed
     */
    public function output($debug, ConfigInterface $config);

    /**
     * Returns true when output should determine format
     * Returns false when format could be resolved by context
     *
     * @return bool
     */
    public function isDeterminingFormat();
}
