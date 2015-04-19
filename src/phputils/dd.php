<?php
use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dd')) {
    /**
     * Wrapper for Symfony Dumper + die
     * @author Unamata Sanatarai <unamatasanatarai@gmail.com>
     */
    function dd($var)
    {
        $callstack = debug_backtrace();
        VarDumper::dump('called from: ' . $callstack[0]['file'] . ':'. $callstack[0]['line']);
        foreach (func_get_args() as $var) {
            VarDumper::dump($var);
        }
        die;
    }
}
