<?php

/**
 * @author Jakub Rapacz <j.rapacz@tvn.pl>
 */

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;

class FormatFile extends FormatAbstract
{
    const FORMAT = 'file';

    const NEW_LINE = "\r\n";
    const HEADER_DELIMITER = '    ';
    const FILE_LOG_DELIMITER = '--------------------------------------------------------------------';

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

        // @TODO - format
        $debug = sprintf(
            "%s%s[%s] %s%s%s%s%s %s%s%s",
            self::NEW_LINE, self::NEW_LINE,
            $config->getOption(ConfigInterface::OPTION_TOKEN),
            $name, self::HEADER_DELIMITER, date('Y-m-d H:i:s'), self::HEADER_DELIMITER, $backtrace['invoke']['file'],
            $backtrace['invoke']['line'], self::NEW_LINE, self::NEW_LINE
        );

        $debug .= $this->dumpVariable($variable, $config);
        $debug .= self::NEW_LINE;

        if ($showBacktrace) {
            $i = 1;
            foreach ($backtrace['trace'] as $trace) {
                $debug .= sprintf(
                    "%d %s() File: %s %s %s",
                    $i++,
                    $trace['callable'],
                    $trace['file'],
                    $trace['line'],
                    self::NEW_LINE
                );
            }
            $debug .= self::NEW_LINE;
        }

        return $debug;
    }
}
