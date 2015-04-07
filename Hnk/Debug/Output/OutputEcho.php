<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Format\FormatHtml;

/**
 * @author pgdba
 */
class OutputEcho implements OutputInterface
{
    const OUTPUT = 'echo';

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

    /**
     * Returns true when output should determine format
     * Returns false when format could be resolved by context
     *
     * @return bool
     */
    public function isDeterminingFormat()
    {
        return false;
    }
}
