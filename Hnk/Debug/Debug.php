<?php

/**
 *
 * @author Kuba
 * @name Debug
 */
class DebugX
{

    const MODE_DEVEL = 1; // all debug is visible
    const MODE_PRODUCTION = 2; // only file debug works
    const MODE_OFF = 9; // debug off

    const CONTEXT_BROWSER = 31;
    const CONTEXT_JSON = 32;
    const CONTEXT_FILE = 33;

    private static $instance = null;

    protected $name;
    protected $mode = self::MODE_OFF;

    protected $debugFile = '';
    protected $fileDebugReady = true;

    const FILE_LOG_DELIMITER = '--------------------------------------------------------------------';
    protected $headerDelimiter = '    ';

    protected $dirMode = 0777;

    protected $token = null;

    protected $maxDepth = 3;

    /**
     *
     * @param type $name
     * @return DebugX
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DebugX();
        }
        return self::$instance;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function hasToken()
    {
        return ($this->token !== null);
    }

    public function setMaxDepth($maxDepth = 4)
    {
        $this->maxDepth = $maxDepth;
    }

    public function __construct()
    {
    }

    /**
     * Formatted debug display
     *
     * @param type $var
     * @param type $name
     * @param type $useDump
     * @param boolean $showBacktrace
     * @param type $exit
     * @param type $style
     * @param type $inception
     * @return type
     */
    public function deb($var = null, $name = '', $useDump = false, $showBacktrace = false, $exit = false, $style = 'DEB', $inception = 1)
    {
        if ($this->mode == self::MODE_OFF) {
            return;
        }
        if ($exit) {
            $showBacktrace = true;
        }

        if ($this->mode == self::MODE_DEVEL) {
            $context = $this->getDebugContext();
            switch ($context) {
                case self::CONTEXT_BROWSER:
                    $debug = $this->preOut($var, $name, $useDump, $showBacktrace, $style, $inception);
                    break;
                case self::CONTEXT_JSON:
                    $debug = $this->jsonOut($var, $name, $useDump, $showBacktrace, $style, $inception);
                    break;
                case self::CONTEXT_FILE:
                    $debug = $this->fileOut($var, $name, $useDump, $showBacktrace, $style, $inception);
                    break;
            }
            echo $debug;
            if ($exit) {
                exit();
            }
        } else {
            $name .= ' (mode prod debug)';
            $debug = $this->fileOut($var, $name, $useDump, $showBacktrace, $style, $inception);
            $this->saveFileDebug($debug);
        }
    }

    /**
     *
     * @param type $var
     * @param type $name
     * @param type $useDump
     * @param boolean $showBacktrace
     * @param type $debugFile
     * @param type $exit
     * @param type $onlyThisDebFile
     * @return type
     */
    public function debFile($var = null, $name = '', $useDump = false, $showBacktrace = false, $debugFile = '', $exit = false, $onlyThisDebFile = false, $inception = 1)
    {
        if ($this->mode == self::MODE_OFF) {
            return;
        }

        if ($onlyThisDebFile) {
            $oldDebugFile = $this->debugFile;
        }
        if ($debugFile || !$this->debugFile) {
            $this->setDebugFile($debugFile);
        }
        if ($exit) {
            $showBacktrace = true;
        }

        $debug = $this->fileOut($var, $name, $useDump, $showBacktrace, $inception);

        $this->saveFileDebug($debug);

        if ($onlyThisDebFile) {
            $this->setDebugFile($oldDebugFile);
        }

        if ($this->mode == self::MODE_DEVEL && $exit) {
            exit();
        }
    }


    /**
     * Debug formated for browser
     * @param type $var
     * @param type $name
     * @param type $useDump
     * @param type $showBacktrace
     * @param type $style
     * @param type $inception
     * @return string
     */
    protected function preOut($var = null, $name = '', $useDump = false, $showBacktrace = false, $style = 'DEB', $inception = 1)
    {
        $definedStyles = array(
//            'DEB'       => 'z-index: 999; opacity: 0.8; background-color: gainsboro; border: 1px solid black; padding:5px; margin: 1px;',
            'DEB' => 'position: relative; z-index: 999; opacity: 0.8; background-color: gainsboro; border: 1px solid black; padding:5px; margin: 1px;',
            'NOTE' => 'background-color: yellowgreen; font-size: 12px; padding: 5px; border: 1px solid black;',
            'BUFFOR' => 'background-color: #0066cc; font-size: 12px; padding: 5px; border: 1px solid black; opacity: 0.6',
            'ERROR' => 'background-color: #ff3300; border: 1px solid black; padding:5px; margin: 1px;'
        );

        $css = (isset($definedStyles[$style])) ? $definedStyles[$style] : $definedStyles['DEB'];

        $currentHtml = '';
        $btrHtml = '';
        $backtrace = debug_backtrace();
        foreach ($backtrace as $key => $val) {
            if ($key < $inception) {
                continue;
            }
            $class = (isset($val['class'])) ? $val['class'] : '';
            $function = (isset($val['function'])) ? $val['function'] : '';
            $file = (isset($val['file'])) ? $val['file'] : '';
            $line = (isset($val['line'])) ? $val['line'] : '';

            if ($function && $key == $inception) {
                $currentHtml = sprintf('<span style="float: right;">%s %s</span>', $file, $line);
            }
            $btrHtml .= sprintf('%d %s %s() File: %s %s <br/>', $key, $class, $function, $file, $line);
        }

        $debug = sprintf('<div style="%s" ondblclick="this.style.display=\'none\'"><b>%s</b>', $css, $name);
        $debug .= $currentHtml;
        if (is_array($var)) {
            $debug .= sprintf('<br/><span style="font-size: 10px">count: %d</span>', count($var));
        }
        $debug .= '<pre>';
        if (!is_array($var) && !is_object($var)) {
            $useDump = true;
        }
        $this->dumpVariable($debug, $var, $useDump);

        if ($showBacktrace) {
            $debug .= '<br/><br/>Backtrace:<br/>';
            $debug .= $btrHtml;
        }

        $debug .= '</pre></div>';

        return $debug;
    }

    /**
     * Debug for file usage
     * @param type $var
     * @param type $name
     * @param type $useDump
     * @param type $showBacktrace
     * @param type $inception
     * @return type
     */
    protected function fileOut($var = null, $name = '', $useDump = false, $showBacktrace = false, $inception = 1)
    {

        $currentHtml = '';
        $btrHtml = '';
        $backtrace = debug_backtrace();
        foreach ($backtrace as $key => $val) {
            if ($key < $inception) {
                continue;
            }
            $class = (isset($val['class'])) ? $val['class'] : '';
            $function = (isset($val['function'])) ? $val['function'] : '';
            $file = (isset($val['file'])) ? $val['file'] : '';
            $line = (isset($val['line'])) ? $val['line'] : '';

            if ($function && $key == $inception) {
                $currentHtml = sprintf('%s %s', $file, $line);
            }
            $btrHtml .= sprintf("%d %s %s() File: %s %s \r\n", $key, $class, $function, $file, $line);
        }


        $debug = '';

        $debug .= sprintf("\r\n\r\n[%s] %s%s%s%s%s\r\n\r\n", $this->token, $name, $this->headerDelimiter, date('Y-m-d H:i:s'), $this->headerDelimiter, $currentHtml);
        $this->dumpVariable($debug, $var, $useDump);
        $debug .= "\r\n";

        if ($showBacktrace) {
            $debug .= $btrHtml;
            $debug .= "\r\n";
        }

        $debug .= "\r\n";
        $debug .= self::FILE_LOG_DELIMITER;

        return $debug;
    }

    /**
     * @todo - all
     *
     *
     * @param type $var
     * @param type $name
     * @param type $useDump
     * @param type $showBacktrace
     * @param type $style
     * @param type $inception
     * @return type
     */
    function jsonOut($var = null, $name = '', $useDump = false, $showBacktrace = false, $style = 'DEB', $inception = 1)
    {
        $currentHtml = '';
        $btrHtml = '';
        $backtrace = debug_backtrace();
        foreach ($backtrace as $key => $val) {
            if ($key < $inception) {
                continue;
            }
            $class = (isset($val['class'])) ? $val['class'] : '';
            $function = (isset($val['function'])) ? $val['function'] : '';
            $file = (isset($val['file'])) ? $val['file'] : '';
            $line = (isset($val['line'])) ? $val['line'] : '';

            if ($function && $key == $inception) {
                $currentHtml = sprintf('%s %s', $file, $line);
            }
            $btrHtml .= sprintf('%d %s %s() File: %s %s <br/>', $key, $class, $function, $file, $line);
        }

        $debug = $name . $this->headerDelimiter . $currentHtml;
        if (!is_array($var) && !is_object($var)) {
            $useDump = true;
        }
        $this->dumpVariable($debug, $var, $useDump);

        if ($showBacktrace) {
            $debug .= '<br/><br/>Backtrace:<br/>';
            $debug .= $btrHtml;
        }
        return $debug;

    }

    protected function dumpVariable(&$debug, $var, $useDump = false)
    {
        $var = $this->exportVariable($var, $this->maxDepth);

        if ($useDump) {
            $tmp = '';
            if (!is_object($var)) {
                $tmp .= sprintf('(%s) ', gettype($var));
            }
//            ob_start();
//            var_dump($var);
//            $tmp = ob_get_clean();
//            @ob_end_clean();
            $tmp .= var_export($var, true);
        } else {
            $tmp = print_r($var, true);
        }

        $debug .= $tmp;

    }

    protected static function exportVariable($var, $maxDepth)
    {
        $return = null;
        $isObj = is_object($var);

        if ($maxDepth) {
            if (is_array($var)) {
                $return = array();

                foreach ($var as $k => $v) {
                    $return[$k] = self::exportVariable($v, $maxDepth - 1);
                }
            } else if ($isObj) {
                $return = new \stdclass();
                if ($var instanceof \DateTime) {
                    $return->__CLASS__ = "DateTime";
                    $return->date = $var->format('c');
                    $return->timezone = $var->getTimeZone()->getName();
                } else {
                    $reflClass = new \ReflectionClass(get_class($var));
                    $return->__CLASS__ = get_class($var);


                    if ($var instanceof \ArrayObject || $var instanceof \ArrayIterator) {
                        $return->__STORAGE__ = self::exportVariable($var->getArrayCopy(), $maxDepth - 1);
                    }

                    foreach ($reflClass->getProperties() as $reflProperty) {
                        $name = $reflProperty->getName();

                        $reflProperty->setAccessible(true);
                        $return->$name = self::exportVariable($reflProperty->getValue($var), $maxDepth - 1);
                    }
                }
            } else {
                $return = $var;
            }
        } else {
            $return = is_object($var) ? get_class($var)
                : (is_array($var) ? 'Array(' . count($var) . ')' : $var);
        }

        return $return;
    }

    /**
     * @todo check context recognition
     * @return type
     */
    public function getDebugContext()
    {
        if (
            (
                isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/wget.*/', trim($_SERVER['HTTP_USER_AGENT']))
            )
            || isset($_SERVER['SHELL'])
        ) {
            return self::CONTEXT_FILE;
        } elseif (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return self::CONTEXT_JSON;
        } else {
            return self::CONTEXT_BROWSER;
        }
    }

    /**
     * Sets debug file
     * @param type $path
     * @return boolean
     */
    public function setDebugFile($path = '')
    {
        if ($path) {
            if (file_exists($path)) {
                if (!is_writable($path)) {
                    // exception
                    return false;
                } else {
                    $this->debugFile = $path;
                }
            } else {
                $dirs = explode(DIRECTORY_SEPARATOR, $path);

                if (is_array($dirs) && !empty($dirs) && count($dirs) > 1) {
                    $file = array_pop($dirs);
                    $path = join(DIRECTORY_SEPARATOR, $dirs);
                    if (!is_dir($path)) {
                        try {
                            $oldUmask = umask(0);
                            mkdir($path, $this->dirMode, true);
                            umask($oldUmask);
                        } catch (Exception $e) {
                            // exception
                            return false;
                        }
                        if (!is_dir($path)) {
                            // exception
                            return false;
                        }
                    }
                    $this->debugFile = $path . DIRECTORY_SEPARATOR . $file;
                } else {
                    $this->debugFile = $path;
                }
            }
        } else {
            // default
            $fileName = 'debug.txt';
            $this->debugFile = dir(__FILE__) . DIRECTORY_SEPARATOR . $fileName;
        }

        $this->fileDebugReady = true;
        return $this;
    }


    /**
     * Saves debug output into debugFile
     * @todo exception handling
     * @param type $debug
     * @return boolean
     */
    protected function saveFileDebug($debug)
    {
        if ($this->mode == self::MODE_OFF) {
            return;
        }

        if (!$this->fileDebugReady) {
            return;
        }

        try {
            $fp = fopen($this->debugFile, 'a');
            fputs($fp, $debug);
            fclose($fp);
        } catch (Exception $e) {

        }
        return true;
    }
}
