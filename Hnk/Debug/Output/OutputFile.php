<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Exception\DebugFileException;
use Hnk\Debug\Exception\UnwritableDirectoryException;
use Hnk\Debug\Exception\UnwritableFileException;
use Hnk\Debug\Format\FormatFile;

/**
 * @author pgdba
 */
class OutputFile implements OutputInterface
{
    const OUTPUT = 'file';

    /**
     * @param string          $debug
     * @param ConfigInterface $config
     *
     * @return null
     */
    public function output($debug, ConfigInterface $config)
    {
        $debugFile = $config->getOption(ConfigInterface::OPTION_DEBUG_FILE);

        try {
            $debugFile = $this->checkDebugFile($debugFile);
        } catch (DebugFileException $e) {
            return; // debug is silenced
        }

        try {
            $fp = fopen($debugFile, 'a');
            fputs($fp, $debug);
            fclose($fp);
        } catch (\Exception $e) {
            return; // debug is silenced
        }
    }

    /**
     * @return string
     */
    public function getDefaultFormatName()
    {
        return FormatFile::FORMAT;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::OUTPUT;
    }

    /**
     * @param  string $debugFile
     *
     * @return string
     *
     * @throws UnwritableDirectoryException
     * @throws UnwritableFileException
     */
    public function checkDebugFile($debugFile)
    {
        if (!file_exists($debugFile)) {
            $directory = dirname($debugFile);
            if (!is_writable($directory)) {
                throw new UnwritableDirectoryException(sprintf('Directory %s is not writable', $directory));
            }

            $h = fopen($debugFile, 'w');
            fclose($h);

            if (!file_exists($debugFile)) {
                throw new UnwritableFileException(sprintf('Cannot create file %s', $debugFile));
            }

            chmod($debugFile, 0755);
        }

        return $debugFile;
    }
}
