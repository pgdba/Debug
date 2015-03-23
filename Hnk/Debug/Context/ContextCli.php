<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hnk\Debug\Context;

/**
 * Description of ContextCli
 *
 * @author pgdba
 */
class ContextCli implements ContextInterface
{
    public function getDefaultFormatName()
    {
        
    }

    public function getName()
    {
        
    }

    public function supports()
    {
        return ('cli' === php_sapi_name());
    }

//put your code here
}
