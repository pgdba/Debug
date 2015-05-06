<?php

namespace {

    use Hnk\Debug\App;
    use Hnk\Debug\Config\ConfigInterface;
    use Hnk\Debug\Dumper;
    use Hnk\Debug\Output\OutputSave;

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

        if (ConfigInterface::MODE_DEVELOP === $dumper->getMode()) {
            exit();
        }
    }

    function fd($var, $name = '', $debugFile = null)
    {
        $dumper = new Dumper();
        if (null !== $debugFile) {
            $dumper->setOption(ConfigInterface::OPTION_DEBUG_FILE, $debugFile);
        }
        $dumper->setOption(ConfigInterface::OPTION_OUTPUT_METHOD, OutputSave::OUTPUT);
        $dumper->dump($var, $name);
    }

    function ddd($maxDepth = 5)
    {
        $app = App::getInstance();
        $app->getConfig()->setOption(ConfigInterface::OPTION_MAX_DEPTH, $maxDepth);
    }

    function err()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
    }

    function registerHelpers()
    {
        $app = App::getInstance();
        $helpers = array(
            'd',
            'ed',
            'fd',
        );

        $app->registerHelpers($helpers);
    }

    registerHelpers();
}
