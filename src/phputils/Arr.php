<?php
/**
 * Flat array utils + tree
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   Unamata Sanatarai <unamatasanatarai@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://github.com/unamatasanatarai/phputils
 * @version  2.0
 */

if (!class_exists('Arr')) {

    /**
     * Flat array utils
     */

    class Arr
    {

        /**
         * Format a nested tree based on parent_id
         * @param  [array] $data       [description]
         * @param  [array] $conditions [description]
         * @return [array]             [description]
         */
        public static function toNestedTree($data = array(), $conditions = array('parent_id' => 0)){
            if (!$data){
                return array();
            }
            $new_data = array();
            $base_tree = Arr::reindex(Arr::getWhere($data, $conditions), 'id');
            foreach ($base_tree as &$node) {
                $children = Arr::reindex(Arr::getWhere($data, array('parent_id' => $node['id'])), 'id');
                foreach($children as $id => $child_node){
                    $children[$id]['children'] = self::toNestedTree($data, array('parent_id' => $child_node['id']));
                }
                $node['children'] = $children;
            }
            return $base_tree;
        }

        /**
         * Find and return value by key in nestedTree
         * @param  [type] $needle   [description]
         * @param  [type] $haystack [description]
         * @return [type]           [description]
         */
        public static function findInNestedTree($needle, $haystack){
            if (isset($haystack[$needle])){
                return $haystack[$needle];
            }
            foreach($haystack as $key => $value) {
                if (is_array($value)){
                    if (isset($value[$needle])){
                        return $value[$needle];
                    }else{
                        $next = self::findInNestedTree($needle, $value);
                        if ($next !== false){
                            return $next;
                        }
                    }
                }
            }
            return false;
        }

        /**
         * Take tree from Tree::format() and prepend names to show indentation levels "--"
         */
        public static function nestedToFlat($data, $name_col = 'name'){
            $return = array();
            foreach ($data as $node) {

                $children = $node['children'];
                unset($node['children']);
                $return[] = $node;

                if (!empty($children)){
                    $children = self::nestedToFlat(
                        $children,
                        $name_col
                    );
                    foreach($children as $child){
                        $child[$name_col] = $node[$name_col] .' > '. $child[$name_col];
                        $return[] = $child;
                    }
                }
            }

            return $return;
        }

        // get nodes where conditions are met
        // getWhere($array, array('parent_id' => 3, 'active' => 1))
        public static function getWhere($data, $conditions){
            $new_data = array();
            $conditions_count = sizeOf($conditions);
            foreach ($data as $node) {
                $conditions_num = 0;
                foreach($conditions as $condition_key => $condition_val){
                    // vd($condition_key, $condition_val);
                    if (Arr::get($node, $condition_key) == $condition_val){
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
