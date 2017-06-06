<?php

namespace Flynt\Utils;

class StringHelpers
{
    /**
    * Converts a string from Camel case to Kebap case.
    *
    * @since 0.1.0
    *
    * @param string $str  The string to convert.
    */
    public static function camelCaseToKebap($str)
    {
        return strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $str));
    }

    /**
    * Strip all HTML tags including script and style,
    * and trims text to a certain number of words.
    *
    * @since 0.1.0
    *
    * @param string $str    The string to trim and strip.
    * @param number $length The string lenght to return.
    */
    public static function trimStrip($str, $length = 25)
    {
        if (isset($str)) {
            return wp_trim_words(wp_strip_all_tags($str), $length, '&hellip;');
        }
        return $str;
    }

    /**
    * Splits a Camel case string.
    *
    * @since 0.1.0
    *
    * @param string $str  The string to split.
    */
    public static function splitCamelCase($str)
    {
        $a = preg_split(
            '/(^[^A-Z]+|[A-Z][^A-Z]+)/',
            $str,
            -1, // no limit for replacement count
            PREG_SPLIT_NO_EMPTY // don't return empty elements
            | PREG_SPLIT_DELIM_CAPTURE // don't strip anything from output array
        );
        return implode($a, ' ');
    }

    /**
    * Converts a string from Kebap case to Camel case.
    *
    * @since 0.1.0
    *
    * @param string $str                        The string to convert.
    * @param boolean $capitalizeFirstCharacter  Sets if the first character should be capitalized.
    */
    public static function kebapCaseToCamelCase($str, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));
        if (false === $capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }

    /**
    * Removes a prefix from a string.
    *
    * @since 0.1.0
    *
    * @param string $prefix The prefix to be removed.
    * @param string $str    The string to manipulate.
    */
    public static function removePrefix($prefix, $str)
    {
        if (substr($str, 0, strlen($prefix)) == $prefix) {
            return substr($str, strlen($prefix));
        }
        return $str;
    }

    /**
    * Checks if a string starts with a certain string.
    *
    * @since 0.1.0
    *
    * @param string $search   The string to search.
    * @param string $subject  The string to look into.

    * @return boolean Returns true if the subject string starts with the search string.
    */
    public static function startsWith($search, $subject)
    {
        return substr($subject, 0, strlen($search)) === $search;
    }

    /**
    * Checks if a string ends with a certain string.
    *
    * @since 0.1.0
    *
    * @param string $search   The string to search.
    * @param string $subject  The string to look into.

    * @return boolean Returns true if the subject string ends with the search string.
    */
    public static function endsWith($search, $subject)
    {
        $searchLength = strlen($search);
        $subjectLength = strlen($subject);
        if ($searchLength > $subjectLength) {
            return false;
        }
        return substr_compare($subject, $search, $subjectLength - $searchLength, $searchLength) === 0;
    }
}
