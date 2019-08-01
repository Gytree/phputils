<?php


namespace Gytree\phputils;


/**
 * Class DirectoryClassesLoader
 * @package Gytree\phputils
 * @author Gytree <pedroguarimata@gmail.com>
 */
class DirectoryClassesLoader
{
    private $path;
    private $classes;
    private $include_function;
    private $classes_extension;
    private $base_namespace;

    /**
     * the root path that should be removed from the files path before to
     * calculate the file namespace. Should be set in order to the included
     * classes have the correct project namespace.
     * @var string
     */
    private $strip_namespace_path;

    public function __construct($path)
    {
        if (!is_dir($path)) {
            throw new \InvalidArgumentException("the given path it's not a directory");
        }
        $this->path = $path;
        $this->classes = [];
        $this->include_function = 'require_once';
        $this->classes_extension = '.php';
        $this->base_namespace = '';
        $this->strip_namespace_path = '/';
    }

    public function getLoadedClasses()
    {
        return $this->classes;
    }

    /**
     * Load all the classes in the directory structure with the require_once function
     */
    public function requireClassesOnce()
    {
        $this->loadDirectoryClasses($this->path);
    }

    private function loadDirectoryClasses($path)
    {
        if (!is_dir($path)) {
            return;
        }
        $files = array_diff(scandir($path), ['.', '..']);
        foreach ($files as $file_name) {
            $complete_path = os_path_join($path, $file_name);
            if (is_dir($complete_path)) {
                $this->loadDirectoryClasses($complete_path);
            } else {
                if (!$this->isAClass($file_name)) {
                    continue;
                }
                $this->include($complete_path);
                $class_name = $this->getNamespaceFromPath($complete_path);
                if (class_exists($class_name)) {
                    $this->classes[] = $class_name;
                }
            }
        }
    }

    private function isAClass($file_name)
    {
        return str($file_name)->endsWidth($this->classes_extension);
    }

    private function include($path)
    {
        switch ($this->include_function) {
            case 'require_once':
            default:
                require_once $path;
        }
    }

    private function getNamespaceFromPath($path)
    {
        $sub_path = str_replace($this->strip_namespace_path, '', $path);
        $sub_path = str_replace($this->classes_extension, '', $sub_path);
        $sub_path = trim($sub_path, '/');
        $sub_path = str_replace('/', '\\', $sub_path);
        return $this->base_namespace . "\\" . $sub_path;

    }

    public function setBaseNamespace($namespace)
    {
        if (!str($namespace)->startsWidth('\\')) {
            $namespace = '\\' . $namespace;
        }
        $this->base_namespace = $namespace;
    }

    public function stripNamespacePath($path)
    {
        $this->strip_namespace_path = $path;
    }
}