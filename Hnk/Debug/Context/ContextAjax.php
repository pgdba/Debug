<?php

namespace Hnk\Debug\Context;
use Hnk\Debug\Format\FormatJson;

/**
 * Description of ContextAjax
 *
 * @author pgdba
 */
class ContextAjax implements ContextInterface
{
    const CONTEXT = 'ajax';

    public function getDefaultFormatName()
    {
        return FormatJson::FORMAT;
    }

    public function getName()
    {
        return self::CONTEXT;
    }

    public function supports()
    {
        return (
            array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) 
            && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
        );
    }
}
