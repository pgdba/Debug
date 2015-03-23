<?php

namespace Hnk\Debug\Format;

use Hnk\Debug\Config\ConfigInterface;
use Hnk\Debug\Context\ContextInterface;
use Hnk\Debug\Output\OutputInterface;

/**
 * Description of FormatResolver
 *
 * @author pgdba
 */
class FormatResolver
{
    protected $formats = [];
    
    public function __construct()
    {
        $this->formats[FormatHtml::FORMAT] = new FormatHtml();
    }
    
    /**
     * 
     * @param  ConfigInterface  $config
     * @param  ContextInterface $context
     * @param  OutputInterface  $output
     * 
     * @return FormatInterface
     */
    public function getFormat(
        ConfigInterface $config, 
        ContextInterface $context,
        OutputInterface $output
    )
    {
        $outputFormat = $config->getOption('outputFormat');
        
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
    
    
}
