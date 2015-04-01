<?php

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;

/**
 * Description of FormatHtml
 *
 * @author pgdba
 */
class FormatHtml extends FormatAbstract
{
    const FORMAT = 'html';
    
    const STYLE_DEBUG = 'style_debug';
    const STYLE_NOTE = 'style_note';
    const STYLE_ERROR = 'style_error';
    
    protected $styles = array(
        self::STYLE_DEBUG => 'position: relative; z-index: 999; opacity: 0.8; background-color: gainsboro; border: 1px solid black; padding:5px; margin: 1px;',
        self::STYLE_NOTE => 'background-color: yellowgreen; font-size: 12px; padding: 5px; border: 1px solid black;',
        self::STYLE_ERROR => 'background-color: #ff3300; border: 1px solid black; padding:5px; margin: 1px;'
    );
    
    public function getFormattedVariable($variable, $name, ConfigInterface $config, $backtrace)
    {
        $style = $config->getOption(ConfigInterface::OPTION_STYLE_HTML, self::STYLE_DEBUG);
        $showBacktrace = $config->getOption(ConfigInterface::OPTION_SHOW_BACKTRACE, false);
        
        if (false === in_array($style, self::getAvailableStyles())) {
            $style = self::STYLE_DEBUG;
        }

        $debug = sprintf(
            '<div style="%s" ondblclick="this.style.display=\'none\'"><b>%s</b>', 
            $this->styles[$style],
            $name
        );
        
        $debug .= sprintf(
            '<span style="float: right;">%s %s</span>', 
            $backtrace['invoke']['file'], 
            $backtrace['invoke']['line']
        );
        
        $debug .= '<pre>';

        $debug .= $this->dumpVariable($variable, $config);
        
        if ($showBacktrace) {
            $debug .= '<br/><br/>Backtrace:<br/>';
            
            $i = 1;
            foreach ($backtrace['trace'] as $trace) {
                $debug .= sprintf(
                    '%d %s() File: %s %s <br/>',
                    $i++,
                    $trace['callable'],
                    $trace['file'],
                    $trace['line']
                );
            }
        }
        
        $debug .= '</pre></div>';
        
        return $debug;
    }

    public function getName()
    {
        return self::FORMAT;
    }
    
    /**
     * @return array
     */
    public static function getAvailableStyles()
    {
        return array(
            self::STYLE_DEBUG,
            self::STYLE_NOTE,
            self::STYLE_ERROR,
        );
    }
}
