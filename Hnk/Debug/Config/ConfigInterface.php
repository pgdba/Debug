<?php

namespace Hnk\Debug\Config;

/**
 * @author pgdba
 */
interface ConfigInterface
{
    /**
     * @param  string $key
     * @param  mixed  $default
     * 
     * @return mixed
     */
    public function getOption($key, $default = null);
}
