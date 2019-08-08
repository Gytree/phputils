<?php

namespace Gytree\phputils;

class Path
{
    /**
     *  Join all given paths using the DIRECTORY_SEPARATOR constant
     * @param string[] $paths
     * @return string
     */
    public static function join($paths)
    {
        $path = '';
        $length = count($paths);
        for ($i = 0; $i < $length; $i++) {
            $path .= ($path === '' ? '' : DIRECTORY_SEPARATOR) . $paths[$i];
        }
        return $path;
    }

    public static function scandir($dir, $strip_dots = false)
    {
        $files = scandir($dir);
        if ($files and $strip_dots) {
            $files = array_diff($files, ['.', '..']);
        }
        return $files;
    }
}
