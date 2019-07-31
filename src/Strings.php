<?php


namespace Gytree\phputils;


/**
 * Class Strings
 * @package Gytree\phputils
 * @author Gytree <pedroguarimata@gmail.com>
 */
class Strings
{
    private $string;
    private $length;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function startsWidth($needle)
    {
        $substr = substr($this->string, 0, strlen($needle));
        return $substr === $needle;
    }

    public function endsWidth($needle)
    {
        $substr = substr($this->string, $this->length() - strlen($needle));
        return $substr === $needle;
    }

    public function length()
    {
        if (is_null($this->length)) {
            $this->length = strlen($this->string);
        }
        return $this->length;
    }
}