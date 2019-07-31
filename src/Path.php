<?php

namespace Gytree\phputils;

class Path
{
    /**
     *  Join all given paths using the DIRECTORY_SEPARATOR constant
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
}
