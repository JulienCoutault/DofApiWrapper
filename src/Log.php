<?php

namespace DofApi;

/**
*  Handler Error log
*/
class Log
{
    public static function red($text)
    {
        error_log("\033[1;31m$text\033[0m");
    }

    public static function green($text)
    {
        error_log("\033[1;32m$text\033[0m");
    }

    public static function yellow($text)
    {
        error_log("\033[1;33m$text\033[0m");
    }

    public static function blue($text)
    {
        error_log("\033[1;34m$text\033[0m");
    }

    public static function pink($text)
    {
        error_log("\033[1;35m$text\033[0m");
    }

    public static function magenta($text)
    {
        error_log("\033[1;35m$text\033[0m");
    }

    public static function cyan($text)
    {
        error_log("\033[1;36m$text\033[0m");
    }

    public static function white($text)
    {
        error_log("\033[1;37m$text\033[0m");
    }

    public static function dump($object = null)
    {
        ob_start();                    // start buffer capture
        var_dump($object);           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log($contents);        // log contents of the result of var_dump( $object )
    }

    public static function __callStatic($name, $args)
    {
        if ($name == 'var_dump') {
            self::dump($args);
        }
    }
}
