<?php

/**
 * @author Jakub Rapacz <j.rapacz@tvn.pl>
 */

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;

class FormatJson implements FormatInterface
{
    const FORMAT = 'json';

    /**
     * Returns format name
     *
     * @return string
     */
    public function getName()
    {
        return self::FORMAT;
    }

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
    public function getFormattedVariable($variable, $name, ConfigInterface $config, $backtrace)
    {
        $showBacktrace = $config->getOption(ConfigInterface::OPTION_SHOW_BACKTRACE, false);
        $verbose = $config->getOption(ConfigInterface::OPTION_VERBOSE, false);

        //@TODO
    }
}
