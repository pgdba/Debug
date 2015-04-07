<?php

namespace Hnk\Debug\Output;

use Hnk\Debug\Config\ConfigInterface;

/**
 * @author pgdba
 */
class OutputFactory
{
    /**
     * @var OutputInterface[]
     */
    public $outputs = array();
    
    /**
     * @param  ConfigInterface $config
     * 
     * @return OutputInterface
     */
    public function getOutput(ConfigInterface $config)
    {
        $mode = $config->getOption(ConfigInterface::OPTION_MODE);

        if (ConfigInterface::MODE_PRODUCTION === $mode) {
            $outputMethod = OutputSave::OUTPUT;
        } else {
            $outputMethod = $config->getOption(ConfigInterface::OPTION_OUTPUT_METHOD, OutputEcho::OUTPUT);
        }
        
        if (array_key_exists($outputMethod, $this->outputs)) {
            return $this->outputs[$outputMethod];
        }
        
        return $this->outputs[OutputEcho::OUTPUT];
    }

    /**
     * @param OutputInterface $output
     */
    public function registerOutput(OutputInterface $output)
    {
        $this->outputs[$output->getName()] = $output;
    }
}
