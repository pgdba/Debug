<?php

namespace Hnk\Debug\Config;

/**
 * @author pgdba
 */
interface ConfigInterface
{
    /**
     * All debugs are visible
     */
    const MODE_DEVELOP = 'develop';

    /**
     * Only file debug works, normal debug is stored in debug file
     */
    const MODE_PRODUCTION = 'production';

    /**
     * All debugs are off
     */
    const MODE_OFF = 'off';

    const OPTION_MODE           = 'mode';
    const OPTION_HELPERS        = 'helpers';
    const OPTION_SHOW_BACKTRACE = 'showBacktrace';
    const OPTION_OUTPUT_FORMAT  = 'outputFormat';
    const OPTION_OUTPUT_METHOD  = 'outputMethod';
    const OPTION_DEBUG_FILE     = 'debugFile';
    const OPTION_MAX_DEPTH      = 'maxDepth';
    const OPTION_VERBOSE        = 'verbose';

    const OPTION_STYLE_HTML     = 'styleHtml';
    const OPTION_TOKEN          = 'token';


    /**
     * @param  string $key
     * @param  mixed  $default
     * 
     * @return mixed
     */
    public function getOption($key, $default = null);
}
