<?php

namespace Hnk\Debug\Context;

/**
 * Description of ContextResolver
 *
 * @author pgdba
 */
class ContextFactory
{
    /**
     * @var ContextInterface[]
     */
    protected $contexts = array();

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

    /**
     * @param ContextInterface $context
     */
    public function registerContext(ContextInterface $context)
    {
        $this->contexts[] = $context;
    }
}
