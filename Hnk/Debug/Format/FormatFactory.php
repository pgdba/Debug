<?php

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextInterface;
use Hnk\Debug\Output\OutputInterface;

/**
 * Description of FormatFactory
 *
 * @author pgdba
 */
class FormatFactory
{
    /**
     * @var FormatAbstract[]
     */
    protected $formats = array();

    /**
     * 
     * @param  ConfigInterface  $config
     * @param  ContextInterface $context
     * @param  OutputInterface  $output
     * 
     * @return FormatAbstract
     */
    public function getFormat(
        ConfigInterface $config, 
        ContextInterface $context,
        OutputInterface $output
    ) {
        $outputFormat = $config->getOption(ConfigInterface::OPTION_OUTPUT_FORMAT);
        
        if (null === $outputFormat) {
            $outputFormat = $output->getDefaultFormatName();
        }
        if (null === $outputFormat) {
            $outputFormat = $context->getDefaultFormatName();
        }
        if (null === $outputFormat) {
            $outputFormat = FormatHtml::FORMAT;
        }
        
        return $this->formats[$outputFormat];
    }

    /**
     * @param FormatAbstract $format
     */
    public function registerFormat(FormatAbstract $format)
    {
        $this->formats[$format->getName()] = $format;
    }
}
