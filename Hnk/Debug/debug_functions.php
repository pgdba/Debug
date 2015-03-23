<?php

/**
 * Zbiór funkcji do debugu, zaincludować w kontrolerze bazowym
 */

if(!function_exists('d')) {
    function ddd($maxDepth = 4) {
        DebugX::getInstance()->setMaxDepth($maxDepth);
    }
    function d($var = null, $name = '', $useDump = false, $showBacktrace = false, $exit = false, $style = 'DEB') {
        DebugX::getInstance()->deb($var, $name, $useDump, $showBacktrace, $exit, $style, 2);
    }
    function ed($var = null, $name = '', $useDump = false, $showBacktrace = false) {
        DebugX::getInstance()->deb($var, $name, $useDump, $showBacktrace, true, 'DEB', 2);
    }
    function e($var = null, $name = '', $useDump = false, $showBacktrace = false, $exit = false, $style = 'ERROR') {
        DebugX::getInstance()->deb($var, $name, $useDump, $showBacktrace, $exit, $style, 2);
    }

    function fd($var = null, $name = '', $useDump = false, $showBacktrace = false, $debugFile = '', $exit = false, $onlyThisDebFile = false) {
        DebugX::getInstance()->debFile($var, $name, $useDump, $showBacktrace, $debugFile, $exit, $onlyThisDebFile, 2);
    }
}

function err() {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}
