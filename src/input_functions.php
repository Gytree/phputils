<?php

if(!defined("INPUTS_SOURCE_STRING_MAP")){
    define("INPUTS_SOURCE_STRING_MAP",  [
        'env' => INPUT_ENV,
        'get' => INPUT_GET,
        'post' => INPUT_POST,
        'cookie' => INPUT_COOKIE,
        'server' => INPUT_SERVER,
    ]);
}

if(!defined("CUSTOM_CALLBACKS_FILTERS")){
    define("CUSTOM_CALLBACKS_FILTERS", [
        'white_chars' => 'filter_no_white_chars',
    ]);
}


if (!function_exists('filter_no_white_chars')) {
    function filter_no_white_chars($text)
    {
        $white_chars = '-_a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\.\040';
        $text = preg_replace("#[^$white_chars]#", '', $text);
        return trim($text);
    }
}

if (!function_exists('input')) {
    /**
     * Return a input value for the input o from the given valid source.
     * @param string $key
     * @param null $default
     * @param mixed $source
     * @param int $filter
     * @return mixed
     */
    function input($key, $source = null, $filter = null, $default = null)
    {
        if (is_null($source)) {
            $source = isset($_POST[$key]) ? INPUT_POST : INPUT_GET;
        } else if (is_string($source) and key_exists(strtolower($source), INPUTS_SOURCE_STRING_MAP)) {
            $source = INPUTS_SOURCE_STRING_MAP[strtolower($source)];
        }
        $options = null;
        if (!is_int($filter) and is_string($filter)) {
            if ($id = filter_id($filter)) {
                $filter = $id;
            } else {
                if (key_exists($filter, CUSTOM_CALLBACKS_FILTERS)) {
                    $options = ['options' => CUSTOM_CALLBACKS_FILTERS[$filter]];
                    $filter = FILTER_CALLBACK;
                } else {
                    if ($filter === 'array') {
                        $options = ['flags' => FILTER_REQUIRE_ARRAY];
                    }
                    if (!function_exists($filter)) {
                        $filter = FILTER_DEFAULT;
                    } else {
                        $options = ['options' => $filter];
                        $filter = FILTER_CALLBACK;
                    }
                }
            }
        } else {
            if (is_callable($filter)) {
                $options = ['options' => $filter];
                $filter = FILTER_CALLBACK;
            } else {
                $filter = FILTER_DEFAULT;
            }
        }
        $result = filter_input($source, $key, $filter, $options);
        if (is_null($result)) {
            $var_value = filter_source_var($source, $key, $filter, $options);
            if (is_phpunit() and $var_value !== false) {
                $result = $var_value;
            }
        }

        return $result ?? $default;
    }
}


if (!function_exists("filter_source_var")) {
    function filter_source_var($source, $key, $filter, $options)
    {
        $global_name = "_" . strtoupper(get_source_name_from_id($source));
        if (isset($GLOBALS[$global_name]) and isset($GLOBALS[$global_name][$key])) {
            return filter_var($GLOBALS[$global_name][$key], $filter, $options);
        }
        return false;
    }
}


if (!function_exists("get_source_name_from_id")) {
    function get_source_name_from_id($id)
    {
        foreach (INPUTS_SOURCE_STRING_MAP as $name => $key) {
            if ($id === $key) {
                return $name;
            }
        }
    }
}
