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

if (!function_exists('scandir_withoutdots')) {
    /**
     * Strip the '.' and '..' for the response array of scandir
     * @param $path
     * @return array|false
     */
    function scandir_withoutdots($path)
    {
        return \Gytree\phputils\Path::scandir($path, true);
    }
}
