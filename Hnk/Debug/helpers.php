<?php

namespace {
    
    use Hnk\Debug\Dumper;
    
    function d($var, $name = '')
    {
        $dumper = new Dumper();
        $dumper->dump($var, $name);
    }
}
