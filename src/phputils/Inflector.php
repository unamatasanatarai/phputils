<?php
/**
 * Inflector taken from CakePHP
 *
 * PHP Version 5
 *
 * @category PHP
 * @package  Phputils
 * @author   cakephp
 * @license  cakephp
 * @link     https://github.com/unamatasanatarai/phputils
 */

if (!class_exists('Inflector')) {

    class Inflector {

        protected static $_transliteration = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
            '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
            '/ç|ć|ĉ|ċ|č/' => 'c',
            '/Ð|Ď|Đ/' => 'D',
            '/ð|ď|đ/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
            '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
            '/ĝ|ğ|ġ|ģ/' => 'g',
            '/Ĥ|Ħ/' => 'H',
            '/ĥ|ħ/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
            '/Ĵ/' => 'J',
            '/ĵ/' => 'j',
            '/Ķ/' => 'K',
            '/ķ/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
            '/Ñ|Ń|Ņ|Ň/' => 'N',
            '/ñ|ń|ņ|ň|ŉ/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
            '/Ŕ|Ŗ|Ř/' => 'R',
            '/ŕ|ŗ|ř/' => 'r',
            '/Ś|Ŝ|Ş|Š/' => 'S',
            '/ś|ŝ|ş|š|ſ/' => 's',
            '/Ţ|Ť|Ŧ/' => 'T',
            '/ţ|ť|ŧ/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
            '/Ý|Ÿ|Ŷ/' => 'Y',
            '/ý|ÿ|ŷ/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž/' => 'Z',
            '/ź|ż|ž/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/' => 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f'
        );

    /**
     * Method cache array.
     *
     * @var array
     */
        protected static $_cache = array();

    /**
     * Cache inflected values, and return if already available
     *
     * @param string $type Inflection type
     * @param string $key Original value
     * @param string $value Inflected value
     * @return string Inflected value, from cache
     */
        protected static function _cache($type, $key, $value = false) {
            $key = '_' . $key;
            $type = '_' . $type;
            if ($value !== false) {
                self::$_cache[$type][$key] = $value;
                return $value;
            }
            if (!isset(self::$_cache[$type][$key])) {
                return false;
            }
            return self::$_cache[$type][$key];
        }

    /**
     * Returns the given lower_case_and_underscored_word as a CamelCased word.
     *
     * @param string $lowerCaseAndUnderscoredWord Word to camelize
     * @return string Camelized word. LikeThis.
     * @link http://book.cakephp.org/2.0/en/core-utility-libraries/inflector.html#Inflector::camelize
     */
        public static function camelize($lowerCaseAndUnderscoredWord) {
            if (!($result = self::_cache(__FUNCTION__, $lowerCaseAndUnderscoredWord))) {
                $result = str_replace(' ', '', Inflector::humanize($lowerCaseAndUnderscoredWord));
                self::_cache(__FUNCTION__, $lowerCaseAndUnderscoredWord, $result);
            }
            return $result;
        }

    /**
     * Returns the given camelCasedWord as an underscored_word.
     *
     * @param string $camelCasedWord Camel-cased word to be "underscorized"
     * @return string Underscore-syntaxed version of the $camelCasedWord
     * @link http://book.cakephp.org/2.0/en/core-utility-libraries/inflector.html#Inflector::underscore
     */
        public static function underscore($camelCasedWord) {
            if (!($result = self::_cache(__FUNCTION__, $camelCasedWord))) {
                $result = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCasedWord));
                self::_cache(__FUNCTION__, $camelCasedWord, $result);
            }
            return $result;
        }

    /**
     * Returns the given underscored_word_group as a Human Readable Word Group.
     * (Underscores are replaced by spaces and capitalized following words.)
     *
     * @param string $lowerCaseAndUnderscoredWord String to be made more readable
     * @return string Human-readable string
     * @link http://book.cakephp.org/2.0/en/core-utility-libraries/inflector.html#Inflector::humanize
     */
        public static function humanize($lowerCaseAndUnderscoredWord) {
            if (!($result = self::_cache(__FUNCTION__, $lowerCaseAndUnderscoredWord))) {
                $result = ucwords(str_replace('_', ' ', $lowerCaseAndUnderscoredWord));
                self::_cache(__FUNCTION__, $lowerCaseAndUnderscoredWord, $result);
            }
            return $result;
        }

    /**
     * Returns a string with all spaces converted to underscores (by default), accented
     * characters converted to non-accented characters, and non word characters removed.
     *
     * @param string $string the string you want to slug
     * @param string $replacement will replace keys in map
     * @return string
     * @link http://book.cakephp.org/2.0/en/core-utility-libraries/inflector.html#Inflector::slug
     */
        public static function slug($string, $replacement = '-') {
            $quotedReplacement = preg_quote($replacement, '/');

            $merge = array(
                '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
                '/\\s+/' => $replacement,
                sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
            );

            $map = self::$_transliteration + $merge;
            return preg_replace(array_keys($map), array_values($map), $string);
        }
    }

}
