<?php

namespace Hnk\Debug;

/**
 * Description of VariableExporter
 *
 * @author pgdba
 */
class VariableExporter
{
    /**
     * @param  mixed  $var
     * @param  int    $maxDepth
     * 
     * @return mixed
     */
    public static function export($var, $maxDepth)
    {
        $return = null;
        $isObj = is_object($var);

        if ($maxDepth) {
            if (is_array($var)) {
                $return = array();

                foreach ($var as $k => $v) {
                    $return[$k] = self::export($v, $maxDepth - 1);
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
                        $return->__STORAGE__ = self::export($var->getArrayCopy(), $maxDepth - 1);
                    }

                    foreach ($reflClass->getProperties() as $reflProperty) {
                        $name = $reflProperty->getName();

                        $reflProperty->setAccessible(true);
                        $return->$name = self::export($reflProperty->getValue($var), $maxDepth - 1);
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
}
