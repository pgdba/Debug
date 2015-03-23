<?php

namespace Hnk\Debug\Context;

/**
 * Description of ContextResolver
 *
 * @author pgdba
 */
class ContextResolver
{
    protected $contexts = [];
    
    public function __construct()
    {
        $this->contexts[] = new ContextBrowser();
    }
    
    /**
     * @return ContextInterface
     */
    public function getContext()
    {
        foreach ($this->contexts as $context) {
            if ($context->supports()) {
                return $context;
            }
        }
    }
}
