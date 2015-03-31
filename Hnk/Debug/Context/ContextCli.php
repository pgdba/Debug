<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hnk\Debug\Context;
use Hnk\Debug\Format\FormatFile;

/**
 * Description of ContextCli
 *
 * @author pgdba
 */
class ContextCli implements ContextInterface
{
    const CONTEXT = 'cli';

    public function getDefaultFormatName()
    {
        return FormatFile::FORMAT;
    }

    public function getName()
    {
        return self::CONTEXT;
    }

    public function supports()
    {
        return ('cli' === php_sapi_name());
    }
}
