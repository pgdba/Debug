<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Format\FormatHtml;

/**
 * @author pgdba
 */
class OutputBrowser implements OutputInterface
{
    const OUTPUT = 'browser';

    /**
     * @return string
     */
    public function getDefaultFormatName()
    {
        return FormatHtml::FORMAT;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::OUTPUT;
    }

    /**
     * @param string          $debug
     * @param ConfigInterface $config
     *
     * @return null
     */
    public function output($debug, ConfigInterface $config)
    {
        echo $debug;
    }
}
