<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;

/**
 * Description of OutputResolver
 *
 * @author pgdba
 */
class OutputResolver
{
    public $outputs = [];
    
    public function __construct()
    {
        $this->outputs[OutputBrowser::OUTPUT] = new OutputBrowser();
    }
    
    /**
     * @param ConfigInterface $config
     * 
     * @return OutputInterface
     */
    public function getOutput(ConfigInterface $config)
    {
        $outputMethod = $config->getOption('outputMethod', OutputBrowser::OUTPUT);
        
        foreach ($this->outputs as $output) {
            if ($output->getName() === $outputMethod) {
                return $output;
            }
        }
        
        return $this->outputs[OutputBrowser::OUTPUT];
    }
}
