<?php

namespace Hnk\Debug\Context;

/**
 *
 * @author pgdba
 */
interface ContextInterface
{
    /**
     * Returns context name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Returns default format name
     * 
     * @return string
     */
    public function getDefaultFormatName();
    
    /**
     * Returns true if ContextInterface matches current context
     */
    public function supports();
}
