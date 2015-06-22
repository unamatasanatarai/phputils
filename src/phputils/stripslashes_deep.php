<?php
/**
 * Strip slashes deep/nested
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   Unamata Sanatarai <unamatasanatarai@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/unamatasanatarai/phputils
 */

if (!function_exists('stripslashes_deep')) {

    function stripslashes_deep($values) {
        if (ini_get('magic_quotes_gpc') !== '1'){
            return $values;
        }

        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $values[$key] = stripslashes_deep($value);
            }
        } else {
            $values = stripslashes($values);
        }
        return $values;
    }
}
