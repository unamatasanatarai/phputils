<?php
/**
 * Wrapper for htmlspecialchars
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   Unamata Sanatarai <unamatasanatarai@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/unamatasanatarai/phputils
 */

if (!function_exists('h')) {

    /**
     * Wrapper for htmlspecialchars
     *
     * @param  string $s [description]
     *
     * @return null
     */
    function h($s){
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }
}
