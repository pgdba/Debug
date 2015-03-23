<?php

namespace Hnk\Debug\Output;

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

    public function output($debug, \Hnk\Debug\Config\ConfigInterface $config)
    {
        echo $debug;
    }
}
