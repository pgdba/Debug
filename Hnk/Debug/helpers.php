<?php

namespace {

    use Hnk\Debug\Config\ConfigInterface;
    use Hnk\Debug\Dumper;

    function d($var, $name = '')
    {
        $dumper = new Dumper();
        $dumper->dump($var, $name);
    }

    function ed($var, $name = '')
    {
        $dumper = new Dumper();
        $dumper->setOption(ConfigInterface::OPTION_SHOW_BACKTRACE, true);
        $dumper->dump($var, $name);
        exit();
    }

    function fd($var, $name = '', $debugFile = null)
    {
        $dumper = new Dumper();
        if (null !== $debugFile) {
            $dumper->setOption(ConfigInterface::OPTION_DEBUG_FILE, $debugFile);
        }
        $dumper->dump($var, $name);
    }

    function ddd($maxDepth = 5)
    {
        global $app;
        $app->getConfig()->setOption(ConfigInterface::OPTION_MAX_DEPTH, $maxDepth);
    }

    function registerHelpers()
    {
        global $app;
        $helpers = array(
            'd',
            'ed',
            'fd',
        );

        $app->registerHelpers($helpers);
    }

    registerHelpers();
}
