<?php

namespace Hnk\Debug\Context;

/**
 * Description of ContextAjax
 *
 * @author pgdba
 */
class ContextAjax implements ContextInterface
{
    public function getDefaultFormatName()
    {
        
    }

    public function getName()
    {
        
    }

    public function supports()
    {
        return (
            array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) 
            && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'
        );
    }

//put your code here
}
