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
class OutputSave implements OutputInterface
{
    const OUTPUT = 'save';

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
            var_dump($debugFile);
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

    /**
     * Returns true when output should determine format
     * Returns false when format could be resolved by context
     *
     * @return bool
     */
    public function isDeterminingFormat()
    {
        return true;
    }
}
