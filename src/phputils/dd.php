<?php
/**
 * Wrapper for Symfony Dumper + die
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   Unamata Sanatarai <unamatasanatarai@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/unamatasanatarai/phputils
 */

use Symfony\Component\VarDumper\VarDumper;

if (!function_exists('dd')) {

    /**
     * Wrapper for Symfony Dupmer + die
     *
     * @return null
     */
    function dd()
    {
        $callstack = debug_backtrace();
        VarDumper::dump(
            'called from: ' . $callstack[0]['file'] . ':'. $callstack[0]['line']
        );
        foreach (func_get_args() as $var) {
            VarDumper::dump($var);
        }
        die;
    }
}
