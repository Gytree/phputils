<?php


if (!function_exists('rmtree')) {
    /**
     * Recursive call the rmdir and the unlink to remove the given directory
     * and all its content. The function return false in case of error or the
     * given path it's equals to '/' :V
     * @param string $path
     * @return bool
     */
    function rmtree($path)
    {
        return \Gytree\phputils\Path::rmtree($path);
    }
}

if (!function_exists('os_path_join')) {
    /**
     * Join all passed parameters string with the DIRECTORY_SEPARATOR constant
     */
    function os_path_join()
    {
        return \Gytree\phputils\Path::join(func_get_args());
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


if (!function_exists('cls_name')) {
    /**
     * Return the short name of the give namespace class
     * @param string $class the complete class name usually the ::class property
     * @return string
     */
    function cls_name($class)
    {
        try {
            $reflection = new ReflectionClass($class);
            return $reflection->getShortName();
        } catch (ReflectionException $e) {
            return '';
        }
    }
}


if (!function_exists('is_phpunit')) {
    function is_phpunit()
    {
        global $argv;
        if (empty($argv)) {
            return false;
        }
        $argv0 = substr($argv[0], strrpos($argv[0], '/') + 1);
        return $argv0 === 'phpunit';
    }
}

include __DIR__ . "/input_functions.php";
