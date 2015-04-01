<?php

namespace {
    use Hnk\Debug\App;
    use Hnk\Debug\Config\ConfigInterface;
    use Hnk\Debug\Context\ContextAjax;
    use Hnk\Debug\Context\ContextBrowser;
    use Hnk\Debug\Context\ContextCli;
    use Hnk\Debug\Format\FormatFile;
    use Hnk\Debug\Format\FormatHtml;
    use Hnk\Debug\Format\FormatJson;
    use Hnk\Debug\Output\OutputBrowser;
    use Hnk\Debug\Output\OutputFile;

    define('APP_DIR', __DIR__);
    define('BASE_DIR', dirname(dirname(APP_DIR)));

    require_once APP_DIR . '/autoload.php';

    if (!defined('HNK_DEBUG_MODE')) {
        define('HNK_DEBUG_MODE', ConfigInterface::MODE_OFF);
    }

    if (!defined('HNK_DEBUG_FILE')) {
        define('HNK_DEBUG_FILE', APP_DIR.'/debug.txt');
    }

    $app = App::getInstance();

    // context resolvers
    $app->getContextFactory()->registerContext(new ContextBrowser());
    $app->getContextFactory()->registerContext(new ContextAjax());
    $app->getContextFactory()->registerContext(new ContextCli());

    // formats
    $app->getFormatFactory()->registerFormat(new FormatHtml());
    $app->getFormatFactory()->registerFormat(new FormatJson());
    $app->getFormatFactory()->registerFormat(new FormatFile());

    // outputs
    $app->getOutputFactory()->registerOutput(new OutputBrowser());
    $app->getOutputFactory()->registerOutput(new OutputFile());

    require_once APP_DIR . '/helpers.php';
}

