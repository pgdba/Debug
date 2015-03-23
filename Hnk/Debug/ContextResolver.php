<?php

namespace Hnk\Debug;

/**
 * Class ContextResolver
 *
 * @author pgdba
 * @package Hnk\Debug
 */
class ContextResolver
{
    const CONTEXT_BROWSER = 'browser';
    const CONTEXT_CLI = 'cli';
    const CONTEXT_AJAX = 'ajax';

    /**
     * Returns current request context
     *
     * @return string
     */
    public function getContext()
    {
        if (true === $this->isContextCli()) {
            return self::CONTEXT_CLI;
        }

        if (true === $this->isContextAjax()) {
            return self::CONTEXT_AJAX;
        }

        return self::CONTEXT_BROWSER;
    }

    /**
     * Checks if script has been executed from console
     *
     * @return bool
     */
    public function isContextCli()
    {
        return ('cli' === php_sapi_name());
    }

    /**
     * Check is script has been executed by ajax request
     *
     * @return bool
     */
    public function isContextAjax()
    {
        return (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest');
    }

    /**
     * :)
     *
     * @return bool
     */
    public function isContextBrowser()
    {
        return true;
    }
}
