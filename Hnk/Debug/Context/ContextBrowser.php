<?php

namespace Hnk\Debug\Context;

use Hnk\Debug\Format\FormatHtml;

/**
 * Description of ContextBrowser
 *
 * @author pgdba
 */
class ContextBrowser implements ContextInterface
{
    const CONTEXT = 'browser';
    
    public function getDefaultFormatName()
    {
        return FormatHtml::FORMAT;
    }

    public function getName()
    {
        return self::CONTEXT;
    }

    public function supports()
    {
        return true;
    }
}
