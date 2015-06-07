<?php
/**
 * Flat array utils
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   Unamata Sanatarai <unamatasanatarai@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/unamatasanatarai/phputils
 */

if (!class_exists('Arr')) {

    /**
     * Flat array utils
     */

    class Arr
    {
        // get nodes where conditions are met
        // getWhere($array, array('parent_id' => 3, 'active' => 1))
        public static function getWhere($data, $conditions){
            $new_data = array();
            $conditions_count = sizeOf($conditions);
            foreach ($data as $node) {
                $conditions_num = 0;
                foreach($conditions as $condition_key => $condition_val){
                    // vd($condition_key, $condition_val);
                    if (array_get($node, $condition_key) == $condition_val){
                        $conditions_num++;
                    }
                }
                if ($conditions_count == $conditions_num){
                    $new_data[] = $node;
                }
            }
            return $new_data;
        }

        // essentially it's a LIB/php/array_get()
        public static function get($data, $keys)
        {
            return (is_string($keys) || is_numeric($keys))
                ? self::getOne($data, $keys)
                : self::getMulti($data, $keys);
        }

        public static function getOne($data, $key)
        {
            return (array_key_exists($key, $data))
                ? $data[$key]
                : null;
        }

        public static function getMulti($data, $keys)
        {
            $r = array();

            foreach($keys as $key)
            {
                $r[$key] = self::get($data, $key);
            }

            return $r;
        }

        public static function extract($data, $keys)
        {
            $r = array();

            foreach($data as $k => $v)
            {
                $r[$k] = self::get($v, $keys);
            }

            return $r;
        }

        public static function reindex($data, $new_key, $new_val = null)
        {
            if (!empty($new_val)){
                return self::reindexFlat($data, $new_key, $new_val);
            }
            $r = array();

            foreach($data as $k => $v)
            {
                $r[$v[$new_key]] = $v;
            }

            return $r;
        }

        public static function reindexFlat($data, $new_key, $new_val)
        {
            $r = array();

            foreach($data as $k => $v)
            {
                $r[$v[$new_key]] = $v[$new_val];
            }

            return $r;
        }

        public static function combine($a, $new_key, $new_val)
        {
            $r = array();

            foreach($a as $k => $v)
            {
                $r[$v[$new_key]] = self::get($v, $new_val);
            }

            return $r;
        }
    }
}
