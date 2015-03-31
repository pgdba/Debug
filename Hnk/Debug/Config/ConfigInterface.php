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

    /**
     * @param  string $key
     * @param  mixed  $default
     * 
     * @return mixed
     */
    public function getOption($key, $default = null);
}
