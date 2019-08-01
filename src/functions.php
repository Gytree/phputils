<?php

if (!function_exists('os_path_join')) {
    /**
     * Join all passed parameters string with the DIRECTORY_SEPARATOR constant
     */
    function os_path_join()
    {
        return \Gytree\phputils\Path::join(func_get_args());
    }
}

if (!function_exists('str')) {
    /**
     * @param $string
     * @return \Gytree\phputils\Strings
     */
    function str($string)
    {
        return new \Gytree\phputils\Strings($string);
    }
}
