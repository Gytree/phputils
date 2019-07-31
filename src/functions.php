<?php

if (!function_exists('path_join')) {
    /**
     * Join all passed parameters string with the DIRECTORY_SEPARATOR constant
     */
    function os_path_join()
    {
        return \Gytree\phputils\Path::join(func_get_args());
    }
}
