<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;

/**
 * Description of OutputBrowser
 *
 * @author pgdba
 */
class OutputBrowser implements OutputInterface
{
    const OUTPUT = 'browser';
    
    public function getDefaultFormatName()
    {
        return null;
    }

    public function getName()
    {
        return self::OUTPUT;
    }

    public function output($debug, ConfigInterface $config)
    {
        echo $debug;
    }
}
