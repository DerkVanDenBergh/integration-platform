<?php

namespace App\Logic\Routes;

class StepFunctions
{
    // TODO check if this is concordant with architecture model

    // Helper functions

    public static function execute($function, $arguments, $data) 
    {
        $arguments = self::parseArguments($arguments, $data, $data);
        

        switch($function->function_name)
        {
            case 'text_var':
                return self::text_var(
                    self::getArgument($arguments, 'text')
                );
                break;
        }
    }

    public static function getArgument($arguments, $name)
    {
        // TODO this can be done faster, for example by swapping argument and parameter around
        foreach($arguments as $argument) {
            if($argument->step_function_parameter->parameter_name == $name) {
                return($argument->value);
            }
        }

        return null;
    }

    // TODO get rid of $originalData
    public static function parseArguments($arguments, $data, $originalData, $keys = [])
    {
        foreach($data as $key=>$value) {

            $currentKeys = $keys;

            if(is_array($value)) {
                array_push($currentKeys, $key);

                self::parseArguments($arguments, $data[$key], $originalData, $currentKeys);
            } else {
                array_push($currentKeys, $key);

                foreach($arguments as $argument) {
                    if(strpos($argument->value, '![' . implode('.', $currentKeys) . ']') !== false) {
                        $argument->value = str_replace('![' . implode('.', $currentKeys) . ']', self::array_access($originalData, $currentKeys), $argument->value);
                    }
                }
            }
        }

        return $arguments;
    }

    private static function array_access(&$array, $keys) {

        if ($keys) {
            $key = array_shift($keys);
    
            $sub = self::array_access(
                $array[$key],
                $keys
            );
    
            return $sub;
        } else {
            return $array;
        }
    }

    // Transformation functions

    public static function text_var($text)
    {
        return $text;
    }

    
}
